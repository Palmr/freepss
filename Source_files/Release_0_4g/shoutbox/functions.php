<?php
// !!!!!!!!!!
// !!BEWARE!!
// !!!!!!!!!!
//
// This file contains A LOT of swearing. Some of you might dissagree with some of the words used, and
// so I thought I might warn you before you read on.
// However, they are not there for fun, but to stop others from using such words, so scroll at your
// own will!

function postimg($error) {
	$code = "				<p><img src=\"image.php\" alt=\"This shoutbox is an image, goto /content.txt to have a screen reader access the messages.\" /></p>\n";
	if($error != ""){
		$code .=  "				<p><span style=\"color:#FF0000;\"><strong>" . $error . "</strong></span></p>\n";
	}
	$code .= "				<form method=\"post\">
					<p><label>Name:<br /><input type=\"text\" name=\"name\" size=\"41\" maxlength=\"20\"></label></p>
					<p><label>Message:<br /><input name=\"content\" size=\"41\" maxlength=\"150\"></textarea></label></p>
					<p><input type=\"submit\" name=\"submit\" value=\"Shout\"></p>
				</form>\n";
	return $code;
}

if($altercontent && $_POST['content']){
	$fn = "content.txt";
	$content = stripslashes($_POST['content']);
	$fp = fopen($fn,"w") or die ("Error opening file in write mode!");
	fputs($fp,$content);
	fclose($fp) or die ("Error closing file!");
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />\n";
}

//Ok, now comes the fun/sweary bit -->
function msgfilter($messagetext) {
	$sm_search = array("fuck",
					   "bitch",
					   "bastard",
					   "cunt",
					   "dick",
					   "cock",
					   "fuk",
					   "knob",
					   "rape",
					   "minge",
					   "bollocks",
					   "nob",
					   "bellend",
					   "twat",
					   "shit",
					   "wank",
					   "penis",
					   "smeg",
					   "piss",
					   "spaz",
					   "mong",
					   "nigger",
					   "prick",
					   " i ",
					   "¬",
					   "¦",
					   "scrot");
	$sm_replace = array("f**k",
						"b***h",
						"b*****d",
						"c**t",
						"d**k",
						"c**k",
						"f**k",
						"k**b",
						"r**e",
						"m**ge",
					   	"b******s",
					   	"k**b",
					   	"b*****d",
					   	"t**t",
					   	"s**t",
					   	"w**k",
					   	"p***s",
					   	"s**g",
					   	"wee wee ",
					   	"intellectual",
					   	"witty fellow",
					   	"n****r",
					   	"p***k",
					   	" I ",
					   	"-",
					   	"|",
						"s***t");
	
	$messagetext = str_replace("\r","", strip_tags(stripslashes(ltrim(trim($messagetext)))));
	$messagetext = str_replace("\t"," ",$messagetext);
	$output = str_replace($sm_search, $sm_replace, strtolower($messagetext));
	$output = strtoupper($output{0}) . substr($output, 1);
	return $output; 
}

// And this is an easter egg, just some credits :D
function credits($uname) {
	$creds = "				<p>This shoutbox system was made by Nick Palmer, Phil Wylie and Rydian Morrison</p>
				<p><a href='http://code.google.com/p/freepss/'>http://code.google.com/p/freepss/</a></p>
				<p><a href='http://www.palmnet.me.uk'>http://www.palmnet.me.uk</a></p>
				<p><a href='http://www.pwnet.org.uk'>http://www.pwnet.org.uk</a></p>
				<p><a href='http://rydian.talkhost.info/'>http://rydian.talkhost.info/</a></p>
				<br />
				<p>Thanks for using the shoutbox " . $uname . ".</p>
				<p>I'd also like to thank the <a href='http://www.gaiaonline.com/'>Gaia online</a> community and all those in the Computers and Tech forum.</p>
				<p><a href='index.php'>Go back to the main page.</a></p>";
	return $creds;
}
?>