<?php
//This is the main code really. It's what gets the input and lets the output be shown.
// Though it's only used once on the index.php
//
//If they have submitted data from the main form
if (isset($_POST['submit']))
{
	//Get the values form the input boxes and strip what we dont allow
	$username = msgfilter($_POST['name']);
	$message = msgfilter($_POST['content']);
	
	//Validate the things they put in there.
	$errorcode = validpost($username,$message);

	//This is one big mother of an if. It decides what you wanted and if you can have it, basically.
	if(isadmin($username) && strtolower($message) == "+edit"){
		echo editform();
	}elseif(!isadmin($username) && strtolower($message) == "+edit"){
		if($errorcode != ""){
			$errorcode .= "<br />And don't try to edit other peoples posts either!";
		}else{
			$errorcode = "You must be the admin to edit other peoples posts.";
		}
		echo postform($errorcode);
	}elseif(strtolower($message) == "+credits"){
		echo credits($username);
	}elseif(isadmin($username)){
		$username = strtoupper($adminname{0}) . substr($adminname, 1);
		if($errorcode == ""){
			postmsg($username,$message);
		}
		echo postform($errorcode);
	}else{
		if($errorcode == ""){
			postmsg($username,$message);
		}
		echo postform($errorcode);
	}
}else{
	//If nothing has happened yet just show the post form.
	// However, if you just goto post.php it will be blank unless it's part of index.php
	echo @postform($errorcode);
}
?>