<?php
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
					   "tard",
					   "nigger",
					   "prick",
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
					   	"genius",
					   	"n****r",
					   	"p***k",
						"s***t");
	
	$messagetext = str_replace("\r","",stripslashes(trim($messagetext)));
	$messagetext = str_replace("\t"," ",$messagetext);
	$output = str_replace($sm_search, $sm_replace, strtolower($messagetext));
	$output = strtoupper($output{0}) . substr($output, 1);
	return $output; 
}

function credits($uname) {
	$creds = "				<p>This shoutbox system was made by Nick Palmer, Phil Wylie and Rydian Morrison</p>
				<p><a href='http://code.google.com/p/freepss/'>http://code.google.com/p/freepss/</a></p>
				<p><a href='http://www.palmnet.me.uk'>http://www.palmnet.me.uk</a></p>
				<p><a href='http://www.pwnet.org.uk'>http://www.pwnet.org.uk</a></p>
				<p><a href='http://rydian.talkhost.info/'>http://rydian.talkhost.info/</a></p>
				<p>Thanks for using the shoutbox " . $uname . ".</p>";
	return $creds;
}

if($altercontent && $_POST['content']){
	$fn = "content.txt";
	$content = stripslashes($_POST['content']);
	$fp = fopen($fn,"w") or die ("Error opening file in write mode!");
	fputs($fp,$content);
	fclose($fp) or die ("Error closing file!");
	echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />\n";
}
?>