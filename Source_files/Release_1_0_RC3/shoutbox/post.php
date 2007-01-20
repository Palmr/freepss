<?php
//This is the main code really. It's what gets the input and lets the output be shown.
// Though it's only ever used once, on the index.php
//
//If they have submitted data from the main form
if (isset($_POST['submit']))
{
	//Get the values form the input boxes and sanitise them
	$username = msgfilter($_POST['name']);
	$message = msgfilter($_POST['content']);
	
	//Validate the things they put in there
	$errorcode = validpost($username,$message);

	//This is one big mother of an if. It decides what you wanted and if you can have it, basically.
	if(isadmin($username) && strtolower($message) == "+edit"){ //If and admin and they want to edit...
		echo editform(); //Give them the edit form
	}elseif(!isadmin($username) && strtolower($message) == "+edit"){//If not an admin and want to edit...
		if($errorcode != ""){//If they already have errors, like attempting to be the admin
			$errorcode .= "<br />And don't try to edit other peoples posts either!"; //Tell them off
		}else{ //Else
			$errorcode = "You must be the admin to edit other peoples posts."; //Just slap the wrist
		}
		echo postform($errorcode); //And echo the normal post form, with the error code
	}elseif(strtolower($message) == "+credits"){ //If they request credits
		echo credits($username); //Give them the credits
	}elseif(isadmin($username)){ //If they are the admin
		$username = strtoupper($adminname{0}) . substr($adminname, 1); //Give them a nice capitalised name
		if($errorcode == ""){ // If no errors..
			postmsg($username,$message); //Post the message
		}
		echo postform($errorcode); //And display the post form
	}else{ //Otherwise
		if($errorcode == ""){ //If no errors
			postmsg($username,$message); //Post the message
		}
		echo postform($errorcode); //and give them the output as normal
	}
}elseif($HTTP_GET_VARS['item'] >= 0 && is_numeric($HTTP_GET_VARS['item'])){ //If they want to see an item
	echo displayhistory($HTTP_GET_VARS['item']); //Show them the specified item
}elseif($HTTP_GET_VARS['guid'] >= 0 && is_numeric($HTTP_GET_VARS['guid'])){ //If they get here from the guid tag
	echo displayhistory(($HTTP_GET_VARS['count'])-($HTTP_GET_VARS['guid'])); //Show them the specified item
}else{
	//If nothing has happened yet just show the post form.
	// However, if you just goto post.php it will be blank unless it's part of index.php
	echo @postform($errorcode);
}
?>