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
?>