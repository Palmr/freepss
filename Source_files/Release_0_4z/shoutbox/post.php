<?php
//For your benefit, to stop people using your name to post bad things, making it look like you posted them
// I have included a password system. Below type your username you will use, and a secret password.
// When you post, rather than put your username in the username feild, you put the password. Nobody will see this
// as it will change it to your username, if people try to use your name, they get told off!

//Enter the admin username and secret word here:
$adminname = "YourUsername";
$secretword = "YouPasswordToUseInstead";


//Do not change anything below this line unless you know what you are doing.
include"functions.php";

if (isset($_POST['submit']))
{
	$file = 'content.txt';
	$name = msgfilter($_POST['name']);
	$message = msgfilter($_POST['content']);
	
	if($name == "" && $message == ""){
		$errorcode = "You need to put a username and a message in the boxes below.";
	}elseif($name == ""){
		$errorcode = "Did not supply a username.";
	}elseif($message == ""){
		$errorcode = "Did not supply a Message to post.";
	}elseif(substr(strtolower($name), 0, strlen(strtolower($adminname))) == strtolower($adminname)){
		$errorcode = "Get a life you sad, sad little script kiddie and stop trying to impersonate the admin!";
	}else{
		$errorcode = "";
	}

	if(strtolower($name) == strtolower($secretword) && strtolower($message) == '+edit'){
		include('editor.php');
	}elseif(strtolower($message) == '+credits'){
		echo credits($name);
	}elseif(strtolower($name) == strtolower($secretword)){
		$name = strtoupper($adminname{0}) . substr($adminname, 1);
		if($errorcode == ""){
			$content = "$name: $message\n" . file_get_contents($file);
			$handle = fopen($file, 'w');
			fwrite($handle, $content);
			fclose($handle);
		}
		echo postimg($errorcode);
	}else{
		if($errorcode == ""){
			$content = "$name: $message\n" . file_get_contents($file);
			$handle = fopen($file, 'w');
			fwrite($handle, $content);
			fclose($handle);
		}
		echo postimg($errorcode);
	}
}else{
	echo postimg($errorcode);
}
?>