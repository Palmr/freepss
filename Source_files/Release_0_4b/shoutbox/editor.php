<?php
if(strtolower($name) == strtolower($secretword) && strtolower($message) == '+edit'){
?>
				<form action="functions.php" method="post">
					<p><textarea rows="10" cols="60" name="content"><?php $fn = "content.txt";
print htmlspecialchars(implode("",file($fn)));?></textarea></p>
					<p><input type="submit" name="altercontent" value="Update"></p>
				</form>
<?php
}else{
?>
				<p><span style=\"color:#FF0000;\"><strong>Naughty naughty! You should know I'd have this secured down!</strong></span></p>
<?php
}
?>