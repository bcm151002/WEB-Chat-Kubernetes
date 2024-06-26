<?php

// CouchDB Configuration
$couchDBUrl = "http://52.166.16.18:30984";
$database = "chat";
$username = "admin";
$password = "password";

// Function to fetch and display the messages
function fetchMessages() {
    global $couchDBUrl, $database, $username, $password;

    $url = "{$couchDBUrl}/{$database}/_all_docs?include_docs=true";
    $context = stream_context_create([
        "http" => [
            "header" => "Authorization: Basic " . base64_encode("$username:$password")
        ]
    ]);
    $response = json_decode(file_get_contents($url, false, $context), true);

    $messages = [];
    if (isset($response['rows'])) {
        foreach ($response['rows'] as $row) {
            $doc = $row['doc'];
            $message = $doc['message'];
            $timestamp = $doc['timestamp'];

            $messages[] = [
                'message' => $message,
                'timestamp' => $timestamp
            ];
        }
    }

    usort($messages, function ($a, $b) {
        return strtotime($a['timestamp']) - strtotime($b['timestamp']);
    });

    return $messages;
}

// Handle Form Submission
if (isset($_POST['submit'])) {
    $newMessage = $_POST['message'];

    $data = [
        'message' => $newMessage,
        'timestamp' => date("c")
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                "Authorization: Basic " . base64_encode("$username:$password"),
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $url = "{$couchDBUrl}/{$database}/";
    $result = file_get_contents($url, false, $context);
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit;
}

// Handle AJAX request
if (isset($_GET['fetchMessages'])) {
    echo json_encode(fetchMessages());
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function fetchMessages() {
        $.get('?fetchMessages', function(messages) {
            let messageContainer = $('#message-container');
            let html = '<table style="border-collapse: collapse; width: 100%;">';
            messages.forEach(function(message) {
                html += '<tr>';
                html += '<td style="border: 1px solid black; padding: 10px;">' + message.timestamp + '</td>';
                html += '<td style="border: 1px solid black; padding: 10px;">' + message.message + '</td>';
                html += '</tr>';
            });
            html += '</table>';
            messageContainer.html(html);
        }, 'json');
    }

    // Fetch messages every 1 second
    setInterval(fetchMessages, 1000);

    $(document).ready(function() {
        fetchMessages(); // Initial fetch
    });
    </script>
</head>
<body>

<!-- HTML Form -->
<form method="POST" action="" style="margin-top: 20px;">
    <textarea name="message" placeholder="Enter your message" style="width: 300px; height: 100px; padding: 10px;"></textarea><br>
    <input type="submit" name="submit" value="Send" style="padding: 10px 20px; background-color: gray; color: white; border: none; cursor: pointer;">
</form>

<div id="message-container"></div>

</body>
</html>
