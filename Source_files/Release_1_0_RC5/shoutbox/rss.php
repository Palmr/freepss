<?php
//The rss.php will return an XML page with an RSS 2.0 feed based on the shoutbox posts.
//
//Include our functions and config
include "functions.php";
include "config.php";

//We need to output this file as a XML file
header("Content-type: text/xml");

//Get our lines, soon to be feed items
$lines = str_replace("\n", "", file($contentfile));
$lines = str_replace("\r", "", $lines);

//I'm using the RSS 2.0 standard here, there is more info: http://www.rssboard.org/rss-specification
// This is just the beginning, declaring things about the feed
$feed = "<?xml version=\"1.0\"?>
<rss version=\"2.0\">
	<channel>
		<title>" . $adminname . "'s Shoutbox Feed</title>
		<link>" . geturldir() . "</link>
		<description>The feed for " . $adminname . "'s shoutbox.</description>
		<lastBuildDate>" . regex_only_timestamp($lines[0]) . "</lastBuildDate>
		<docs>http://www.rssboard.org/rss-specification</docs>
		<generator>The Evolution Group RSS Feed Generator</generator>\n\n";

//We then need to loop through our RSS items/lines, start at 0
$i = 0;
//And loop from 0 while $i is smaller than the max count we want (from the config file)
while($i < $rssitemcount) {
	//Each time we add to the feed a new item like this...
	$feed .= "		<item>
			<title>" . regex_timestamp_off($lines[$i]) . "</title>
			<link>" . geturldir() . "index.php?item=" . $i . "</link>
			<description>" . regex_timestamp_cutdown($lines[$i]) . "</description>
			<pubDate>" . regex_only_timestamp($lines[$i]) . "</pubDate>
			<guid isPermaLink=\"true\">" . geturldir() . "index.php?guid=" . (count($lines) - $i) . "&amp;count=" . count($lines) . "</guid>
		</item>\n";
	//If the next line is blank then we have run out of lines! So set $i > $rssitemcount to quit the loop
	if($lines[($i+1)]==""){$i=$rssitemcount;}
	//Otherwise make $i one bigger for the next line and loop again
	$i++;
}

//Then output the end of the RSS feed, closing any still-open tags
$feed .= "\n	</channel>
</rss>";

//And echo to the browser so the user can see them
echo $feed;
?>
