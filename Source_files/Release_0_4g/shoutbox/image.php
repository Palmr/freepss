<?php
header ('Content-Type: image/gif');
$file = 'content.txt';
$lines = str_replace("\n", '', file($file));
$lines = str_replace("\r", '', $lines);

//Location of the background for the shoutbox image:
$image = imagecreatefromjpeg('design/background.jpg');

//RGB colour of the text:
$text_color = imagecolorallocate($image, 55, 55, 55);



//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//!!Do not mess with the code below this line unless you know what you're doing!!
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// Rydian Morrison is responsible for the following loop, with my nifty value of Y for any image though :D
// Rydian deserves all the credit he can get for this bit though!
$y = (floor(imagesy($image)/imagefontheight(2)) * imagefontheight(2)) - imagefontheight(2);

for ($i = 0; $i < count($lines); $i++)
{
	$text = wordwrap($lines[$i], floor((imagesx($image)-11)/imagefontwidth(2)), "\n", 1);
	$text = explode("\n", $text);
	
	for ($j = (count($text) - 1); $j >= 0; $j--)
	{
		imagestring($image, 2, 7, $y, $text[$j], $text_color);
		$y -= imagefontheight(2);
	}
}

imagegif($image);
?>