
<?php require('head.php');?>
	<!-- Nom des onglets -->
		<title>Ressource</title>

<div class="container" style="margin : 100px">

          <div class="col-md-2 sidebar ">
            <ul class="nav nav-tabs nav-stacked">
               <li><a href="rMDI.php">MDI</a></li>
               <li><a href="rGCRHM.php">GCRHM</a></li>
               <li><a href="rJHF.php">JNF</a></li>
               <li><a href="rRT.php">RT</a></li>
               <li><a href="rEEIIN.php">EEIIN</a></li>
                
                </form>
                </ul>	
          </div>


   <?php
$dir = 'upload/rMDI';
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
 </div>
<?php require('body.php');?>
<?php require('footer.php');?>
