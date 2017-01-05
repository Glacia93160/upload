<?php
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
  }
  else
  {
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
 if($_POST["formations"]=="Formation Modulaire et Diplômante Interuniversitaire"){
  if (file_exists("upload/rMDI" . $_FILES["file"]["name"]))
  {
  echo $_FILES["file"]["name"] . " already exists. ";
  }
  else
  {
  move_uploaded_file($_FILES["file"]["tmp_name"],
  "upload/rMDI" . $_FILES["file"]["name"]);
  echo "Stored in: " . "upload/rMDI" . $_FILES["file"]["name"];
  }
  }
  }
  header('HTTP/1.1 301 Moved Permanently');
  header('Location:files.php');
?>
