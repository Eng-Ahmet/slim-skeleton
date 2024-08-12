<?php
// for start don't forget rquires libraries
// composer require cboden/ratchet
// all work

declare(strict_types=1);

namespace API;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class Web_Socket implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        $notificationMessage = json_encode(['message' => 'A new user has joined the chat.', 'type' => 'NewUser']);
        foreach ($this->clients as $client) {
            $client->send($notificationMessage);
        }

        if ($this->clients->count() == 1) {
            $conn->send(json_encode(['message' => 'You are the only one here.', 'type' => 'notification']));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        $notificationMessage = json_encode(['message' => 'A user has left the chat.', 'type' => 'notification']);
        foreach ($this->clients as $client) {
            $client->send($notificationMessage);
        }

        if ($this->clients->count() === 1) {
            $client = $this->clients->current();
            $client->send(json_encode(['message' => 'You are now alone.', 'type' => 'notification']));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        $message = $data['message'];
        $type = $data['type'];

        echo "Received message from {$from->resourceId}: {$message}\n";

        // Send message to all clients except the sender
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }

        // Acknowledge the message back to the sender only if it's not a regular message
        if ($type !== 'regular') {
            $response = "You said: {$message}";
            $from->send(json_encode(['message' => $response, 'type' => 'regular']));
        }
    }
}

// Create WebSocket server
$WebSocket_server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Web_Socket()
        )
    ),
    8080
);

echo "WebSocket server started at port 8080\n";
$WebSocket_server->run();
