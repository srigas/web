<?php

$success = "";
$error = "";
$name = $message = $email = "";
$errors = array('name' => '', 'email' => '', 'message' => '');

$mail_to = 'contact@srigas.me';

function SanitizeString($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    return stripslashes($var);
}

if (empty(trim($_POST["name"]))) {
	$errors['name'] = "The name field was left blank.";
	?>
		<script language="javascript" type="text/javascript">
			alert('The name field was left blank.');
			window.location = history.back();
		</script>
	<?php
} else {
	$name = SanitizeString($_POST["name"]);
	if (!preg_match('/^[a-zA-Z\s]{1,25}$/', $name)) {
		$errors['name'] = "Please enter a valid name.";
		?>
		<script language="javascript" type="text/javascript">
			alert('Please enter a valid name.');
			window.location = history.back();
		</script>
	<?php
	}
}

if (empty(trim($_POST["email"]))) {
	$errors["email"] = "The email field was left blank.";
	?>
		<script language="javascript" type="text/javascript">
			alert('The email field was left blank.');
			window.location = history.back();
		</script>
	<?php
} else {
	$email = SanitizeString($_POST["email"]);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors["email"] = "Please enter a valid email address.";
		?>
		<script language="javascript" type="text/javascript">
			alert('Please enter a valid email address.');
			window.location = history.back();
		</script>
	<?php
	}
}

if (empty(trim($_POST["message"]))) {
	$errors["message"] = "Please type a message.";
	?>
		<script language="javascript" type="text/javascript">
			alert('The message field was left blank.');
			window.location = history.back();
		</script>
	<?php
} else {
	$message = SanitizeString($_POST["message"]);
	if (!preg_match("/[^A-Za-z0-9]/", $message)) { 
		$errors["message"] = "You may have entered an invalid character in your message body.";
		?>
		<script language="javascript" type="text/javascript">
			alert('You may have entered an invalid character in your message body.');
			window.location = history.back();
		</script>
	<?php
	}
}

if (array_filter($errors)) {
} else {
	
	$subject = 'Message from site visitor '.$name;

	$body_message = 'From: '.$name."\n";
	$body_message .= 'E-mail: '.$email."\n";
	$body_message .= 'Message: '.$message;
	
	$headers = 'From: '.$email."\r\n";
	$headers .= 'Reply-To: '.$email."\r\n";

	$mail_status = mail($mail_to, $subject, $body_message, $headers);
	
	if ($mail_status) { ?>
	<script language="javascript" type="text/javascript">
		alert('Thank you for the message! I will contact you shortly.');
		window.location = 'index.html';
	</script>
	<?php
	}
	else { ?>
		<script language="javascript" type="text/javascript">
			alert('Message failed. Please, send an email to contact@srigas.me');
			window.location = history.back();
		</script>
	<?php
	}
}

?>