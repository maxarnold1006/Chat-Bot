$(document).ready(function() {


	
	// Send message when Send button is clicked
	$('#send-button').click(function() {
		var message = $('#message-input').val();
		if (message !== '') {
			ajax_send_message(message);
			$('#message-input').val('');
		}
	});

	// Log out when Log Out button is clicked
	$('#logout-button').click(function() {
		$.ajax({
			url: 'logout.php',
			type: 'get',
			success: function(response) {
				window.location.replace('index.php');
			},
			error: function(xhr) {
				console.log(xhr.responseText);
			}
		});
	});

	$('#filter-button').click(function() {

		// Get the keyword from the search box
		var keyword = $('#filter-input').val();
		// Send an AJAX request to retrieve the latest 200 messages with the given keyword
		$.ajax({
			url: 'server.php',
			type: 'get',
			data: { action: 'get_latest_200_messages', keyword: keyword },
			success: function(response) {
				$('#filtered-message-board').html(response);
			},
			error: function(xhr) {
				console.log(xhr.responseText);
			}
		});
	});	

	// Retrieve latest 200 messages on page load
	setInterval(function() {
		ajax_get_latest_200_messages();
	  }, 5000); // Refresh every 5 seconds


});

function ajax_send_message(message) {

	// Get the username from the session
	var username = '<?php echo $_SESSION["username"]; ?>';

	$.ajax({
		url: 'server.php',
		type: 'post',
		data: { message: message, username: username },
		success: function(response) {
			console.log(response);
			// Reload latest messages
			ajax_get_latest_200_messages();
		},
		error: function(xhr) {
			console.log(xhr.responseText);
		}
	});

}

$(document).ready(function() {

	// Retrieve latest 200 messages on page load
	ajax_get_latest_200_messages();

});

function ajax_get_latest_200_messages() {

	$.ajax({
		url: 'server.php',
		type: 'get',
		data: { action: 'get_latest_200_messages' },
		success: function(response) {
			$('#message-board').html(response);
		},
		error: function(xhr) {
			console.log(xhr.responseText);
		}
	});

}

function filterMessages() {
	var keyword = document.getElementById("filterKeyword").val();
		// Send an AJAX request to retrieve the latest 200 messages with the given keyword
		$.ajax({
			url: 'server.php',
			type: 'get',
			data: { action: 'get_latest_200_messages', keyword: keyword },
			success: function(response) {
				$('#filtered-message-board').html(response);
			},
			error: function(xhr) {
				console.log(xhr.responseText);
            }
        });
    };



