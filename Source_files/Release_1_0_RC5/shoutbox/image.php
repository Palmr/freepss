<?php
//The image.php file is the one that outputs the shoutbox image.
// This is the file you link to when using the shoutbox on various sites.
//
//Include the config.php because we need some variables from it
include "config.php";
include "functions.php";

//Set the header to make the browser display this as a gif image
header ('Content-Type: image/gif');

//These headers make sure we don't use a cached version [Thanks to WindPower for this tip]
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

//Open the file with the content in so we can read it and display it on the shoutbox image
$lines = str_replace("\n", "", file($contentfile));
$lines = str_replace("\r", "", $lines);

//This code shows the timestamps or not, dependant on the config.php
// Some rather large regex's now. Means it's back compatible though
if(!$timestamps) {
	$lines = regex_timestamp_off($lines);
}else{
	$lines = regex_timestamp_cutdown($lines);
}

//Load the images into variables
$image = imagecreatefromjpeg($shoutboximg);
$sigimg = imagecreatefromjpeg($shoutboxbgimg);

//RGB colour of the text using the textcolour variable from config and the hex2rgb from functions:
$text_colour = imagecolorallocate($image, hex2rgb($textcolour,"r"), hex2rgb($textcolour,"g"), hex2rgb($textcolour,"b"));
$shadow_colour = imagecolorallocate($image, hex2rgb($shadowcolour,"r"), hex2rgb($shadowcolour,"g"), hex2rgb($shadowcolour,"b"));



//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!Do not mess with the code below this line unless you know what you're doing!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//The value of Y is amount of full lines of text we can squeeze into the shoutbox image
$y = (floor(imagesy($image)/imagefontheight(2)) * imagefontheight(2)) - imagefontheight(2);
// Rydian Morrison is responsible for the following loop, It's ace, word wraps and draws every line :D
for ($i = 0; $i < count($lines); $i++)
{
	//Indent idea courtesy of Hoggs "\n " instead of "\n"
	$text = wordwrap($lines[$i], floor((imagesx($image)-12)/imagefontwidth(2)), "\n ", 1);
	$text = explode("\n", $text);
	
	for ($j = (count($text) - 1); $j >= 0; $j--)
	{
		if($shadow){
			imagestring($image, 2, 7, ($y+1), $text[$j], $shadow_colour);
		}
		imagestring($image, 2, 6, $y, $text[$j], $text_colour);
		$y -= imagefontheight(2);
	}
}

//Copy the shoutbox part of the image onto the main shoutbox image
imagecopyresampled($sigimg, $image, $Xval, $Yval, 0, 0, imagesx($image), imagesy($image), imagesx($image), imagesy($image));

//Output the final image to the user
imagegif($sigimg);
?>