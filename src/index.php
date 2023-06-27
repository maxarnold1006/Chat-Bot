<!DOCTYPE html>
<html>
<head>
	<title>Chat App</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php
session_start();

// If user is not logged in, show login form
if (!isset($_SESSION['username'])) {
?>

	<form method="post">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username">
		<label for="password">Password:</label>
		<input type="password" id="password" name="password">
		<input type="submit" value="Log In">
	</form>

<?php
	// Check if the username and password are correct
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Array of usernames and passwords
		$users = array(
			'Max' => 'Tcw123',
			'Bethany' => 'Css789',
			'Lawrence' => 'Itc370'
		);

		// Check if the username and password are valid
		if (isset($users[$username]) && $users[$username] == $password) {
			// Store the username in a session variable
			$_SESSION['username'] = $username;

			// Redirect to chat app
			header('Location: index.php');
			exit();
		} else {
			echo "<p>Invalid username or password.</p>";
		}
	}
} else {
	// If user is logged in, show chat app
?>
<div>
	<h1>Chat</h1>
	<div id="message-board"></div>
	<button id="logout-button">Log Out</button>
	<input type="text" id="message-input" placeholder="Type your message...">
	<button id="send-button">Send</button>
</div>

<div>
	<h4>Filtered Messages</h4>
	<div id="filtered-message-board"></div>
	<input type="text" id="filter-input" placeholder="Type your filter...">
	<button id="filter-button" onclick="filterMessages()">Filter</button>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
<script>

function filterMessages() {
	var keyword = document.getElementById("filter-input").value;
	var messages = document.getElementById("message-board").innerHTML;
	var filteredMessages = "";

	// Split messages by line and filter by keyword
	messages.split("<br>").forEach(function(line) {
		if (line.includes(keyword)) {
			filteredMessages += line + "<br>";
		}
	});

	// Display filtered messages
	var filteredMessagesDiv = document.getElementById("filtered-message-board");
  	if (filteredMessages === "") {
    filteredMessagesDiv.style.display = "none";
  	} else {
    filteredMessagesDiv.style.display = "block";
    filteredMessagesDiv.innerHTML = filteredMessages;
  }
}
</script>

<?php
}
?>

</body>
</html>

