<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/settings/icon" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            websocket.send(JSON.stringify({ type: 'authenticate', key: key }));
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
            }
            else if(type === 'newUser') {
                document.getElementById("chat-box").innerHTML = "";
                addMessage("System", message, "alert alert-danger");

            }
            else {
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
</head>
<body>
    <h1>Upload Product</h1>
    <form action="/product/add" method="POST" enctype="multipart/form-data">
        <!-- Required Fields -->
        <label for="store_id">Store ID:</label>
        <input type="text" id="store_id" name="store_id" required><br><br>

        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_price">Product Price:</label>
        <input type="text" id="product_price" name="product_price" required><br><br>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" required></textarea><br><br>

        <label for="stock_quantity">Stock Quantity:</label>
        <input type="text" id="stock_quantity" name="stock_quantity" required><br><br>

        <label for="SKU">SKU:</label>
        <input type="text" id="SKU" name="SKU" required><br><br>

        <label for="product_weight">Product Weight:</label>
        <input type="text" id="product_weight" name="product_weight" required><br><br>

        <label for="product_dimensions">Product Dimensions:</label>
        <input type="text" id="product_dimensions" name="product_dimensions" required><br><br>

        <label for="manufacturer">Manufacturer:</label>
        <input type="text" id="manufacturer" name="manufacturer" required><br><br>

        <label for="brand">Brand:</label>
        <input type="text" id="brand" name="brand" required><br><br>

        <label for="category_id">Category ID:</label>
        <input type="text" id="category_id" name="category_id" required><br><br>

        <label for="sub_category_id">Sub Category ID:</label>
        <input type="text" id="sub_category_id" name="sub_category_id" required><br><br>

        <!-- File Upload -->
        <label for="product_images">Product Images:</label>
        <input type="file" id="product_images" name="product_images[]" multiple><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
