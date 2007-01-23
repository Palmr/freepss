<?php
//Functions.php has all the functions needed for the shoutbox. And even some that aren't needed!
//
// Here is a basic rundown of all the function here:
//  + writetofile(content) - This write all the shoutbox data to the content file
//  + writeconfig(content) - This saves the settings in a nicely formatted config.php
//  + postmsg(username, message) - This posts a users message
//  + isadmin(password) - returns true or false dependant on the pass provided
//  + validpost(username, message) - This is some error checking and security
//  + editform() - Returns the form for editing posts/settings
//  + postform(errormessage) - Return the forum user's use to post messages
//  + displayhistory(item) - Displays nicely the history surrounding that shout item
//  + bool2ckec(bool) - Returns checked if true
//  + check2bool(checked value) - Returns true if checked
//  + hex2rgb(hexvalue, outputvalue) - Input a hex value and it gets R,G or B from the outputvalue
//  + msgfilter(message) - Filters out swear words, fixes some common mistakes and removes non-ascii characters
//  + credits(username) - Shows some nice credits
//  + geturl() - Returns the current url: http://www.site.com/folder/file.php
//  + geturldir() - Returns the current url's base directory: http://www.site.com/folder/
//
// !!!!!!!!!!
// !!BEWARE!!
// !!!!!!!!!!
// This file contains A LOT of swearing. Some of you might disagree with some of the words used, and
//  so I thought I might warn you before you read on.
//  However, they are not there for fun, but to stop others from using such words, so scroll at your
//  own will!


//Include the config file for variables we may need.
include "config.php";


//Function to write all the data to the shoutbox file or tell the user otherwise.
function writetofile($content) {
	global $contentfile;
	$fp = @fopen($contentfile,"w");
	if(!@fputs($fp,$content)){
		if(!@chmod($contentfile,0777)) {
			echo "Please tell the admin he has not set the permissions right on the '" . $contentfile . "' file.";
		}
		else {
			$fp=fopen($contentfile, "w");
			fputs($fp,$content);
			fclose($fp);
		}
	}else{
		fclose($fp);
	}
}


//Function to write the config file
function writeconfig($content) {
	$fp = @fopen("config.php","w");
	if(!@fputs($fp,$content)){
		if(!@chmod("config.php",0777)) {
			echo "Please tell the admin he has not set the permissions right on the 'config.php' file.";
		}
		else {
			$fp=fopen("config.php", "w");
			fputs($fp,$content);
			fclose($fp);
		}
	}else{
		fclose($fp);
	}
}


//If they used the edit form write the edited file
if($_POST['editcfg']){
	//Write the content changes
	$content = stripslashes($_POST['content']);
	writetofile($content);
	//Validate the values (Beware, lots of validation, huge!)
	if($_POST["cfgUsername"]==""){
		$cfgUsername=$adminname;
	}else{
		$cfgUsername= strtoupper($_POST["cfgUsername"]{0}) . substr($_POST["cfgUsername"], 1);
	}
	if($_POST["cfgPassword"]==""){
		$cfgPassword=$adminpassword;
	}else{
		$cfgPassword=$_POST["cfgPassword"];
	}
	if($_POST["cfgContentfile"]==""){
		$cfgContentfile=$contentfile;
	}else{
		$cfgContentfile=$_POST["cfgContentfile"];
	}
	if($_POST["cfgRsscount"]=="" || $_POST["cfgRsscount"] <= 0 || !is_numeric($_POST["cfgRsscount"])){
		$cfgRsscount=$rssitemcount;
	}else{
		$cfgRsscount=$_POST["cfgRsscount"];
	}
	if($_POST["cfgTcol"]==""){
		$cfgTcol=$textcolour;
	}else{
		$cfgTcol=strtoupper(str_replace("#","",$_POST["cfgTcol"]));
	}
	if($_POST["cfgScol"]==""){
		$cfgScol=$textcolour;
	}else{
		$cfgScol=strtoupper(str_replace("#","",$_POST["cfgScol"]));
	}
	if($_POST["cfgSbimg"]=="" || substr(strtolower($_POST["cfgSbimg"]), -4, 4)!=".jpg"){
		$cfgSbimg=$shoutboximg;
	}else{
		$cfgSbimg=$_POST["cfgSbimg"];
	}
	if($_POST["cfgSbbgimg"]=="" || substr(strtolower($_POST["cfgSbbgimg"]), -4, 4)!=".jpg"){
		$cfgSbbgimg=$shoutboxbgimg;
	}else{
		$cfgSbbgimg=$_POST["cfgSbbgimg"];
	}
	if($_POST["cfgXval"]=="" || $_POST["cfgXval"] < 0 || !is_numeric($_POST["cfgXval"])){
		$cfgXval=$Xval;
	}else{
		$cfgXval=$_POST["cfgXval"];
	}
	if($_POST["cfgYval"]=="" || $_POST["cfgYval"] < 0 || !is_numeric($_POST["cfgYval"])){
		$cfgYval=$Yval;
	}else{
		$cfgYval=$_POST["cfgYval"];
	}
	//Build the config file
	$content = '<?php
	//Admin details
	$adminname = "' . $cfgUsername . '";
	$adminpassword = "' . $cfgPassword . '";

	//The location of the content file
	$contentfile = "' . $cfgContentfile . '";

	//Shoutbox options
	$textcolour = "' . $cfgTcol . '";
	$shadowcolour = "' . $cfgScol . '";
	$rssitemcount = ' . $cfgRsscount . ';
	$timestamps = ' . check2bool($_POST["cfgTstamp"]) . ';
	$shadow = ' . check2bool($_POST["cfgShadow"]) . ';

	//Shoutbox image options
	$shoutboximg = "' . $cfgSbimg . '";
	$shoutboxbgimg = "' . $cfgSbbgimg . '";
	$Xval = ' . $cfgXval . ';
	$Yval = ' . $cfgYval . ';
?>';
	writeconfig($content); //And save it!
}


//If they want to post a message, format it and write it
function postmsg($username,$message) {
	global $contentfile;
	$content = "[".date('D, d M Y H:i:s T')."]$username: $message\n" . file_get_contents($contentfile);
	writetofile($content);
}


//Function to see if we have the admin
function isadmin($password) {
	global $adminpassword;
	if(strtolower($password) == strtolower($adminpassword)){
		return true;
	}else{
		return false;
	}
}


//Validate the post form data
function validpost($username,$message) {
	global $adminname;
	if($username == "" && $message == ""){
		return "You must put a username and a message in the boxes below.";
	}elseif($username == ""){
		return "You must supply a username.";
	}elseif($message == ""){
		return "You must supply a Message to post.";
	}elseif(substr(strtolower(ltrim(trim($username))), 0, strlen(strtolower($adminname))) == strtolower($adminname)){
		return "Stop trying to impersonate the owner of this shoutbox!";
	}else{
		return "";
	}
}


//If they want the edit form give it to them
function editform() {
	global $adminname, $adminpassword, $contentfile, $rssitemcount, $timestamps, $shadow, $textcolour, $shadowcolour, $shoutboximg, $shoutboxbgimg, $Xval, $Yval;
	$fp = fopen($contentfile, "r");
	$filedata = fread($fp, filesize($contentfile));
	fclose($fp);
	$form = "				<form method=\"post\" action=\"index.php\">
					<p><textarea rows=\"10\" cols=\"60\" name=\"content\">" . $filedata . "</textarea></p>
					<p>Admin Username: <input name=\"cfgUsername\" type=\"text\" maxlength=\"50\" value=\"" . $adminname . "\" /></p>
					<p>Admin Password: <input name=\"cfgPassword\" type=\"text\" maxlength=\"50\" value=\"" . $adminpassword . "\" /></p>
					<p>Text colour: #<input name=\"cfgTcol\" type=\"text\" maxlength=\"6\" value=\"" . $textcolour . "\" /></p>
					<p>Timestamps: <input name=\"cfgTstamp\" type=\"checkbox\" " . bool2check($timestamps) . " /></p>
					<p>Shadow: <input name=\"cfgShadow\" type=\"checkbox\" " . bool2check($shadow) . " /></p>
					<p>Shadow colour: #<input name=\"cfgScol\" type=\"text\" maxlength=\"6\" value=\"" . $shadowcolour . "\" /></p>
					<p>Number of items in RSS feed: <input name=\"cfgRsscount\" type=\"text\" maxlength=\"2\" value=\"" . $rssitemcount . "\" /></p>
					<p>Content file location: <input name=\"cfgContentfile\" type=\"text\" maxlength=\"50\" value=\"" . $contentfile . "\" /></p>
					<p>Shoutbox area image: <input name=\"cfgSbimg\" type=\"text\" value=\"" . $shoutboximg . "\" /></p>
					<p>Full shoutbox image: <input name=\"cfgSbbgimg\" type=\"text\" value=\"" . $shoutboxbgimg . "\" /></p>
					<p>Shoutbox X<small>(px)</small>: <input name=\"cfgXval\" type=\"text\" maxlength=\"3\" value=\"" . $Xval . "\" /></p>
					<p>Shoutbox Y<small>(px)</small>: <input name=\"cfgYval\" type=\"text\" maxlength=\"3\" value=\"" . $Yval . "\" /></p>
					<p><input type=\"submit\" name=\"editcfg\" value=\"Save changes\" /></p>
				</form>\n";
	return $form;
}


//If the want the post form give it to them
function postform($errormessage) {
	$form = "				<p><img src=\"image.php\" alt=\"This shoutbox is an image, go to /index.php?item=0 to have a screen reader access the messages.\" /></p>\n";
	if($errormessage != ""){
		$form .=  "				<p><span id=\"error\">" . $errormessage . "</span></p>\n";
	}
	$form .= "				<form method=\"post\" action=\"index.php\">
					<p><label>Name:<br /><input type=\"text\" name=\"name\" size=\"41\" maxlength=\"20\" /></label></p>
					<p><label>Message:<br /><input name=\"content\" size=\"41\" maxlength=\"150\" /></label></p>
					<p><input type=\"submit\" name=\"submit\" value=\"Shout\" /></p>
				</form>\n";
	return $form;
}

//If they want the previous shout history
function displayhistory($item) {
	global $contentfile;
	//Open the file with the content in so we can read the lines we need
	$lines = str_replace("\n", '', file($contentfile));
	$lines = str_replace("\r", '', $lines);
	//Generate the history
	$data = "				<p><span class=\"dimmer\">" . regex_timestamp_cutdown(htmlentities($lines[($item+2)])) . "</span></p>
				<p><span class=\"dim\">" . regex_timestamp_cutdown(htmlentities($lines[($item+1)])) . "</span></p>
				<p><span class=\"focus\">" . regex_timestamp_cutdown(htmlentities($lines[$item])) . "</span></p>
				<p><span class=\"dim\">" . regex_timestamp_cutdown(htmlentities($lines[($item-1)])) . "</span></p>
				<p><span class=\"dimmer\">" . regex_timestamp_cutdown(htmlentities($lines[($item-2)])) . "</span></p>
				<div id=\"options\">
					<ul id=\"navlist\">
						<li><a href=\"" . geturldir() . "index.php?item=" . min(($item+1), count($lines)-1) . "\" id=\"older\">Older</a></li>
						<li><a href=\"index.php\">Main Page</a></li>
						<li><a href=\"" . geturldir() . "index.php?item=" . max(($item-1),0) . "\" id=\"newer\">Newer</a></li>
					</ul>
				</div>
				<br />\n";
	return $data;
}


//Couple of functions to convert Boolean to checkbox style and back
function bool2check($booleanvalue) {
	if($booleanvalue){
		return "checked";
	}else{
		return "";
	}
}
function check2bool($checkvalue) {
	if(strtolower($checkvalue) == "on"){
		return "true";
	}else{
		return "false";
	}
}
//Function for returning RGB values of a hex value
function hex2rgb($hex, $value) {
	str_replace("#","",$hex);
	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));
	if(strtolower($value) == "r"){
		return $r;
	}elseif(strtolower($value) == "g"){
		return $g;
	}elseif(strtolower($value) == "b"){
		return $b;
	}else{
		return $r.",".$g.",".$b;
	}
}

//Ok, now comes the sweary bit -->
// You have been warned!
// [This rewrite is courtesy of Dan Horgan]
function msgfilter($message) {
	//We strip all non-normal characters
	$message = str_replace("\r","", stripslashes(ltrim(trim($message))));
	$message = preg_replace('/[^-\\]\\\\~!@#$%^&*()_+=|{}[\'";:,.\/?><`\\w\\s]/im','',$message ); //Thanks to Windpower for this working, evil character stripping, code
	//Then replace some of the more common mistakes
	$innocent_replacements = array(" i " => " I ", 
									"teh " => "the ", 
									" adn " => " and ", 
									" jsut " => " just ", 
									" mroe " => " more ", 
									" alot " => " a lot ", 
									" untill " => " until ", 
									" tomoro " => " tomorrow ", 
									" im " => " I'm ", 
									" ive " => " I've ", 
									" youve " => " you've ", 
									" cant " => " can't ", 
									" wouldnt " => " wouldn't ", 
									" couldnt " => " couldn't ", 
									" shouldnt " => " shouldn't ", 
									"`" => "'", 
									 "¬" => "-", 
									 "¦" => "|", 
									 "\t" => " ");
	foreach ($innocent_replacements as $old => $new)
	{
		$message = str_replace($old, $new, $message);
	}
	//Block out some more unsavoury turns of phrase
	$not_very_nice = array("fuck",
						"cunt",
						"minge",
						"twat",
						"dick",
						"cock",
						"penis",
						"knob",
						"bellend",
						"prick",
						"smeg",
						"bollocks",
						"bitch",
						"bastard",
						"rape",
						"shit",
						"piss",
						"wank",
						"spaz",
						"mong",
						"nigger",
						"niggah");
	//If found, we block out all the letters but the first and last				
	foreach ($not_very_nice as $word)
	{
		$pattern = "/(?i)[" . join(preg_split('//', $word, -1, PREG_SPLIT_NO_EMPTY), "][") . "]/e";
		$replacement = "substr('$0', 0, 1) . str_repeat('*', (strlen('$0') - 2)) . substr('$0', -1, 1)";
		$message = preg_replace($pattern, $replacement , $message);
	};
	//Capitalise first letter
	$message = strtoupper($message{0}) . substr($message, 1);
	//And give the restult back to the function
	return $message; 
}


// And this is just some credits :D
function credits($username) {
	global $adminname;
	$credits = "				<p>This shoutbox system was <small>mostly</small> made by Nick Palmer, Phil Wylie and Rydian Morrison</p>
				<p><img src=\"design/logo.jpg\" alt=\"Logo image\" title=\"Shoutbox system Logo\" /></p>
				<p><a href=\"http://code.google.com/p/freepss/\">http://code.google.com/p/freepss/</a></p>
				<p><a href=\"http://www.palmnet.me.uk/\">http://www.palmnet.me.uk/</a></p>
				<p><a href=\"http://www.pwnet.org.uk/\">http://www.pwnet.org.uk/</a></p>
				<p><a href=\"http://rydian.talkhost.info/\">http://rydian.talkhost.info/</a></p>
				<p><a href=\"http://leoleonardo.deviantart.com/\">http://leoleonardo.deviantart.com/</a></p>
				<p>Thank you to <strong>Nick Palmer</strong> for updating, ideas and hours of work.</p>
				<p>Cheers to <strong>Phil Wylie</strong> for the nice design, PHP mentorship and ideas.</p>
				<p>Grazie to <strong>Rydian Morrison</strong> for the original base shoutbox code.</p>
				<p>Merci to <strong>Dan Horgan</strong> for the new message filter.</p>
				<p>Gracias to <strong>Fredrik \"Leo\" Gustafsson</strong> for the logo.</p>
				<p>Danke to <strong>WindPowa</strong> for the frame killer code, PHP help and RSS idea.</p>
				<p>Muchas gracias to <strong>Hoggs</strong> and <strong>Kairu2468</strong> For their support of the project, ideas and general code.</p>
				<p>Thanks to " . $adminname . " for choosing to use our shoutbox system.</p>
				<p>And thank you for using the shoutbox " . htmlentities($username) . ".</p>
				<br />
				<p>I'd also like to thank the <a href='http://www.gaiaonline.com/'>Gaia online</a> community and all those in the Computers and Tech forum.</p>
				<p><a href='index.php'>Go back to the main page.</a></p>\n";
	return $credits;
}

//These functions are mainly used by the RSS feed, could be handy for other things though
// This one gets the full url of the page calling it: http://www.site.com/folder/page.php
function geturl() {
	return "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] ;
}
// This one gets the url up to the folder of the page calling it: http://www.site.com/folder/
function geturldir() {
	return "http://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "/";
}

//Regular expression functions. Used here and there, and too big really, so put in functions
function regex_timestamp_off($line) {
	return preg_replace('/(\\[((\\w{3}, \\d{2} \\w{3} \\d{4} )?(\\d{2}:\\d{2})(am|pm|:\\d{2} (.)+)?)\\])(.+)/im','$7',$line);
}
function regex_timestamp_cutdown($line) {
	return preg_replace('/(\\[((\\w{3}, \\d{2} \\w{3} \\d{4} )?(\\d{2}:\\d{2})(am|pm|:\\d{2} (.)+)?)\\])(.+)/im','[$4] $7',$line);
}
function regex_only_timestamp($line) {
	return preg_replace('/(\\[((\\w{3}, \\d{2} \\w{3} \\d{4} )?(\\d{2}:\\d{2})(am|pm|:\\d{2} (.)+)?)\\])(.+)/im','$2',$line);
}
?>