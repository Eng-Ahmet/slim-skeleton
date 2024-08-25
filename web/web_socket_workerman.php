<?php

declare(strict_types=1);

namespace API;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\TcpConnection;

define('VALID_KEY', '800879'); // valid key

// Create a Websocket server
$ws_worker = new Worker("websocket://localhost:8000/");

// 4 processes
$ws_worker->count = 4;

$clients = [];
$authenticatedClients = [];

// Handle new connections
$ws_worker->onConnect = function (TcpConnection $connection) use (&$clients) {
    $clients[$connection->id] = $connection;
    //echo "New connection: {$connection->id}\n";
};

// Handle messages
$ws_worker->onMessage = function (TcpConnection $connection, $data) use (&$clients, &$authenticatedClients) {
    $data = json_decode($data, true);

    // Handle authentication
    if (isset($data['type']) && $data['type'] === 'authenticate') {
        $key = $data['key'] ?? '';
        if ($key !== VALID_KEY) {
            $connection->send(json_encode(['message' => 'Invalid key.', 'type' => 'error']));
            $connection->close();
            return;
        }
        $authenticatedClients[$connection->id] = $connection;
        $connection->send(json_encode(['message' => 'Authentication successful.', 'type' => 'notification']));

        // Notify other clients that a new user has joined
        foreach ($authenticatedClients as $client) {
            // if ($client->id !== $connection->id) {
            //     $client->send(json_encode(['message' => 'A new user has joined the chat.', 'type' => 'newUser']));
            // }
            $client->send(json_encode(['message' => 'A new user has joined the chat.', 'type' => 'newUser']));
        }
        return;
    }

    // Ensure the client is authenticated
    if (!isset($authenticatedClients[$connection->id])) {
        $connection->send(json_encode(['message' => 'You are not authenticated.', 'type' => 'error']));
        return;
    }

    $message = $data['message'];
    $type = $data['type'];

    //echo "Received message from {$connection->id}: {$message}\n";

    // Send message to all clients except the sender
    foreach ($authenticatedClients as $client) {
        if ($client->id !== $connection->id) {
            $client->send(json_encode(['message' => $message, 'type' => 'regular']));
        }
    }

    // Acknowledge the message back to the sender only if it's not a regular message
    if ($type !== 'regular') {
        $response = "You said: {$message}";
        $connection->send(json_encode(['message' => $response, 'type' => 'regular']));
    }
};

// Handle connection closures
$ws_worker->onClose = function (TcpConnection $connection) use (&$clients, &$authenticatedClients) {
    unset($clients[$connection->id]);
    unset($authenticatedClients[$connection->id]);
    //echo "Connection closed: {$connection->id}\n";

    if (!empty($authenticatedClients)) {
        // Notify remaining users that someone has left
        $notificationMessage = json_encode(['message' => 'A user has left the chat. All messages have been cleared.', 'type' => 'notification']);
        foreach ($authenticatedClients as $client) {
            $client->send($notificationMessage);
        }

        // Clear chat history
        foreach ($authenticatedClients as $client) {
            $client->send(json_encode(['message' => 'clear', 'type' => 'system']));
        }

        // Check if only one user is left
        if (count($authenticatedClients) === 1) {
            $client = reset($authenticatedClients);
            $client->send(json_encode(['message' => 'You are now alone. The chat history has been cleared.', 'type' => 'notification']));
        }
    }
};

// Run worker
Worker::runAll();
