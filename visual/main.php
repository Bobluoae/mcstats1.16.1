<h1>MAIN</h1>
<!-- import form for getting users permission to scan data -->
<div class="box">
	<!-- info -->
	<p>Press the button if you want to scan your Minecraft statistics throughout all your singleplayer worlds.</p>
	<p>Remember you have to copy your file path to your Minecraft/Saves folder.</p> 
	<p>Your path will be teporarily stored for ease of use.</p>
	<br>
	<!-- error message -->
	<?=$message?>
	<!-- add path to session -->
	<form method="post" onsubmit="submit.disabled = true; return true;">
		<input type="hidden" name="path_sent" value="path">
		<textarea name="path" rows="5" placeholder="Copy your path here!"></textarea><br>
		<input type="submit" value="Set Path">
	</form>
	<br>
</div>
<br>
<!-- Call import function with post variables-->
<form method="post" onsubmit="submit.disabled = true; return true;">
	<input type="submit" name="submit" value="Import/Renew">
	<input type="hidden" name="action" value="import">
</form>
<?=$_SESSION["path"]?>