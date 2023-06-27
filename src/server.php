<?php
// Start the session if it is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the AJAX request is for saving a message
if (isset($_POST['message'])) {
    $message = $_POST['message'];
    $username = $_SESSION['username'];
    save_message_to_chat_file($message, $username);
}

// Check if the AJAX request is for retrieving the latest 200 messages
if (isset($_GET['action']) && $_GET['action'] == 'get_latest_200_messages') {
    $messages = get_latest_200_message_from_chat_file();
    echo $messages;
}

function save_message_to_chat_file($msg, $username) {
    date_default_timezone_set('UTC');
    $time = date('Y-m-d H:i:s');
    $filename = 'chat_log.txt';
    $fp = fopen($filename, 'a');
    if (flock($fp, LOCK_EX)) {
        fwrite($fp, $username . ': ' . $msg . ' ' . $time."\n");
        flock($fp, LOCK_UN);
    }
    fclose($fp);
}

function get_latest_200_message_from_chat_file($keyword = '') {
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    $filename = 'chat_log.txt';
    $file_array = file($filename);
    $last_200_lines = array_slice($file_array, -200);
    $messages = '';
    foreach ($last_200_lines as $line) {
        if ($keyword === '' || strpos($line, $keyword) !== false) {
            $messages .= "<p>" . $line . "</p>";
        }
    }
    return $messages;
}
?>
