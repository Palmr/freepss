<?php
//The image.php file is the one that outputs the shoutbox image.
// This is what you link to when using ths shoutbox on various sites.
//
//Include the config.php because we need some variables from it
include "config.php";

//Set the header to make the browser display this as a gif image
header ('Content-Type: image/gif');

//Open the file with the content in so we can read it and display it on the shoutbox image
$lines = str_replace("\n", '', file($contentfile));
$lines = str_replace("\r", '', $lines);

//This code shows the timestamps or not, dependant on the config.php
if(!$timestamps) {
	$lines = preg_replace("/\[[0-9][0-9]:[0-9][0-9](am|pm)?\]/","",$lines);
}else{
	$lines = preg_replace("/(\[[0-9][0-9]:[0-9][0-9])(am|pm)?(\])/","$1$3",$lines); //Compatability for 0.5
}

//Load the images into variables
$image = imagecreatefromjpeg($shoutboximg);
$sigimg = imagecreatefromjpeg($shoutboxbgimg);

//RGB colour of the text:
$text_color = imagecolorallocate($image, 55, 55, 55);



//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!Do not mess with the code below this line unless you know what you're doing!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//The value of Y is amount of full lines of text we can squeeze into the shutbox image
$y = (floor(imagesy($image)/imagefontheight(2)) * imagefontheight(2)) - imagefontheight(2);
// Rydian Morrison is responsible for the following loop, It's ace, word wraps and draws every line :D
for ($i = 0; $i < count($lines); $i++)
{
	//Indent idea courtesy of Hoggs
	$text = wordwrap($lines[$i], floor((imagesx($image)-11)/imagefontwidth(2)), "\n  ", 1);
	$text = explode("\n", $text);
	
	for ($j = (count($text) - 1); $j >= 0; $j--)
	{
		imagestring($image, 2, 7, $y, $text[$j], $text_color);
		$y -= imagefontheight(2);
	}
}

//Copy the shoutbox part of the image onto the main shoutbox image
imagecopyresampled($sigimg, $image, $Xval, $Yval, 0, 0, imagesx($image), imagesy($image), imagesx($image), imagesy($image));

//Output the final image to the user
imagegif($sigimg);
?>