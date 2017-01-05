<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>php文件上传与下载_www.xfcodes.com</title>
</head>
 
<body>
<form action="upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="hidden" name="max_file_size" value="1000000000">
<input type="file" name="file" id="file" />
<input type="submit" name="submit" value="Submit" />
</form>
<br/>
<br/>
<table width="400" border="1">
<?php
$dir = 'upload/';
if(is_dir($dir)) {
        if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
                if($file!="." && $file!="..") {
                echo "<tr><td><a href='".$dir.$file."'>".$file."</a></td></tr>";
            }
        }
        closedir($dh);
     }
}
?>
</table>
</body>
</html>