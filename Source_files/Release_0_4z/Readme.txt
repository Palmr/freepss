+-----------------------------+
|                             |
|   Palmnet Shoutbox System   |
|                        v0.4z|
+-----------------------------+


-> What is the Palmnet Shoutbox System?
-> Why did I download this?
-> What do I do with it?
-> Does it really work?
-> Who made this?
-> Why did they make this?
-> How can I join your team?
-> Is there more in the pipeline?



:What is the Palmnet Shoutbox System?
-------------------------------------
The Palmnet Shoutbox System(PSS) Is a system based on a PHP script that uses the GD library to render the shoutbox image straight to the screen.
This gives you the added advantage of including the PSS on any forum or website, and have it update automatically everytime the page is refreshed.
Not only that, but the PSS comes complete with a page for users to easily shout in your box.


:Why did I download this?
-------------------------
You downloaded it because you wanted a cool and nifty shoutbox like everyone else!
And because you have PHP hosting that was going to waste and you thought you might install several copies and give them to other's without the capabilty to get PHP hosting. Because you're kind ^^
If you are caught selling these on with no added features then you will be told off. A lot!


:What do I do with it?
----------------------
Well, I take it you downloaded either an archive, or each file individually. If an archive, extract it to a folder first.
Well, then you just use your FTP software to upload all the files in the "shoutbox" folder to your hosted webspace. Then with your ftp software you can usually set the permissions, properties or some how or another "chmod" the files. If you do not know how, ask somone who will.
You need to chmod the 'content.txt' file to '0777' otherwise people will not be able to post!
Once that is done it's all setup and ready to go! Feel free to start posting.
However....
If you want to protect your username to stop other people posting with it, open the file in the "shoutbox" folder named "post.php" in something like notepad. You will see a some code with something like:
	$adminname = "YourUsername";
	$secretword = "YouPasswordToUseInstead";
At the top. Just change the bits between the quotes to your desired stuff E.g.
	$adminname = "palmer";
	$secretword = "+password";
Now to post with the name "Palmer" I put "+password" into the username feild instead, if you put "Palmer" it will tell you off!
PS: make sure you keep that secret word secret!
Also for you admin's, put your password in the username feild like you normally would, but put "+edit" in the message feild. That way you can quickly remove any unsavoury posts to your shoutbox :)
If you want to customise the look of the shoutbox, or the website feel free, but please keep the footer and comments the same. Anyone found to be in violation with these terms will not only recieve a telling off, but also public humiliation by being NAMED AND SHAMED!


:Does it really work?
---------------------
Well of course it does!
Wouldnt be much use us giving it to you, you downloading it and then uploading it again if it didn't work.
There is no catch. Well, apart from keeping the credits, but that's more common courtesy than a rule.
Look here to see it in action: http://sandbox.palmnet.me.uk/shoutbox/


:Who made this?
---------------
Why it was me, of course!
Me being Nick Palmer, aka Palmnet. http://www.palmnet.me.uk
The posting page design was done by Philip Wylie of PWnet. http://www.pwnet.org.uk
The code for word wrapping in the shoutbox was done by a kindly fellow named Rydian Morrison.


:Why did they make this?
------------------------
Well me, Nick, wanted one all for myself, but never really got round to it due to the word wrapping conundrum. But thanks to alot of help from Rydian, and some nifty design from PWnet, It's all been put together in one easy package for you all to share the joy.
We all believe open source is the recipe for a good program or a "killer" app. And this is our first, of hopefully many, Open source application.
(To find out more goto: http://code.google.com/p/freepss/ )


:How can I join your team?
-------------------------------
We are allways welcome for new members to our development team. We are currently looking for: PHP developers, beta testers, and graphic designers.
So if you think you would like to help, or could contribute in any way, whape or form then email me: whitehat586@gmail.com


:Is there more in the pipeline?
-------------------------------
Why yes!
As allways we have too many ideas and too little time to do them all in!
So far you can await:
> The Gaia shop managers system
> Delta CMS (http://code.google.com/p/deltacms/)
> Quest bar system
> www.HowToUseA.com
> www.Evolution-Online.co.uk
And many more.... Stay tuned!