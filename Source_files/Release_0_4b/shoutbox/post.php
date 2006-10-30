<?php
//For your benefit, to stop people using your name to post bad things, making it look like you posted them
// I have included a password system. Below type your username you will use, and a secret password.
// When you post, rather than put your username in the username feild, you put the password. Nobody will see this
// as it will change it to your username, if people try to use your name, they get told off!

//Enter the admin username and secret word here:
$adminname = "YourUsername";
$secretword = "YouPasswordToUseInstead";


//Do not change below this line unless you know what you are doing.
$errorcodes = array("","You need to put a username and a message in the boxes below.","Did not supply a username.","Did not supply a Message to post.","Get a life you sad, sad little script kiddie and stop trying to impersonate the admin!");

include"functions.php";

if (isset($_POST['submit']))
{
	$file = 'content.txt';
	$name = msgfilter($_POST['name']);
	$message = msgfilter($_POST['content']);
	
	if($name == "" && $message == ""){
		$errorcode = 1;
	}elseif($name == ""){
		$errorcode = 2;
	}elseif($message == ""){
		$errorcode = 3;
	}elseif(substr(strtolower($name), 0, strlen(strtolower($adminname))) == strtolower($adminname)){
		$errorcode = 4;
	}else{
		$errorcode = 0;
	}

	if(strtolower($name) == strtolower($secretword) && strtolower($message) == '+edit'){
		include('editor.php');
	}elseif(strtolower($message) == '+credits'){
		echo credits($name);
	}elseif(strtolower($name) == strtolower($secretword)){
		$name = strtoupper($adminname{0}) . substr($adminname, 1);
		if($errorcode == 0){
			$content = "$name: $message \n" . file_get_contents($file);
			$handle = fopen($file, 'w');
			fwrite($handle, $content);
			fclose($handle);
			?>
				<p><img src="image.php" alt="This shoutbox is an image, goto /content.txt to have a screen reader access the messages." /></p>
<?php if($errorcode >= 1){echo "				<p><span style=\"color:#FF0000;\"><strong>" . $errorcodes[$errorcode] . "</strong></span></p>\n";} ?>
				<form method="post">
					<p><label>Name:<br /><input type="text" name="name" size="41" maxlength="20"></label></p>
					<p><label>Message:<br /><input name="content" size="41" maxlength="150"></textarea></label></p>
					<p><input type="submit" name="submit" value="Shout"></p>
				</form>
<?
		}
	}else{
		if($errorcode == 0){
			$content = "$name: $message \n" . file_get_contents($file);
			$handle = fopen($file, 'w');
			fwrite($handle, $content);
			fclose($handle);
			?>
				<p><img src="image.php" alt="This shoutbox is an image, goto /content.txt to have a screen reader access the messages." /></p>
<?php if($errorcode >= 1){echo "				<p><span style=\"color:#FF0000;\"><strong>" . $errorcodes[$errorcode] . "</strong></span></p>\n";} ?>
				<form method="post">
					<p><label>Name:<br /><input type="text" name="name" size="41" maxlength="20"></label></p>
					<p><label>Message:<br /><input name="content" size="41" maxlength="150"></textarea></label></p>
					<p><input type="submit" name="submit" value="Shout"></p>
				</form>
<?
		}
	}
}else{
				?>
				<p><img src="image.php" alt="This shoutbox is an image, goto /content.txt to have a screen reader access the messages." /></p>
<?php if($errorcode >= 1){echo "				<p><span style=\"color:#FF0000;\"><strong>" . $errorcodes[$errorcode] . "</strong></span></p>\n";} ?>
				<form method="post">
					<p><label>Name:<br /><input type="text" name="name" size="41" maxlength="20"></label></p>
					<p><label>Message:<br /><input name="content" size="41" maxlength="150"></textarea></label></p>
					<p><input type="submit" name="submit" value="Shout"></p>
				</form>
<?
}
?>