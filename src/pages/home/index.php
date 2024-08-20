<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/settings/icon" type="image/x-icon">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <title>WebSocket Chat Example</title>
    <style>
        #chat-box {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .message {
            margin-bottom: 10px;
        }

        .message .sender {
            font-weight: bold;
        }
    </style>
    <script>
        var key = "800879"; // المفتاح الصحيح
        var websocket = new WebSocket("ws://localhost:8080/");

        websocket.onopen = function(event) {
            console.log("WebSocket connection established.");
            // Send the key for verification
            websocket.send(JSON.stringify({
                type: 'authenticate',
                key: key
            }));
        };

        websocket.onmessage = function(event) {
            var data = JSON.parse(event.data);
            var message = data.message;
            var type = data.type;

            if (type === 'notification') {
                addMessage("Notification", message, "alert alert-info");
            } else if (type === 'error') {
                addMessage("Error", message, "alert alert-danger");
            } else if (type === 'system') {
                // Clear chat history
                document.getElementById("chat-box").innerHTML = "";
                addMessage("System", message, "alert alert-warning");
            } else if (type === 'newUser') {
                document.getElementById("chat-box").innerHTML = "";
                addMessage("System", message, "alert alert-danger");

            } else {
                addMessage("Client", message);
            }
        };

        websocket.onerror = function(event) {
            addMessage("Error", "WebSocket error occurred.", "alert alert-danger");
        };

        function sendMessage() {
            var inputMessage = document.getElementById("message").value;
            if (inputMessage.trim() === "") return;

            var data = {
                message: inputMessage,
                type: 'regular'
            };
            websocket.send(JSON.stringify(data));
            addMessage("You", inputMessage);
            document.getElementById("message").value = "";
        }

        function addMessage(sender, message, alertClass = "alert alert-secondary") {
            var chatBox = document.getElementById("chat-box");
            var messageDiv = document.createElement("div");
            messageDiv.className = "message " + alertClass;
            messageDiv.innerHTML = `<span class="sender">${sender}:</span> ${message}`;
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>

</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">WebSocket Chat Example</h1>
        <div id="chat-box" class="mb-3"></div>
        <div class="input-group">
            <input type="text" id="message" class="form-control" placeholder="Enter message...">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</body>

</html>