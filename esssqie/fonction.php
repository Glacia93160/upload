
<?php
$nomOrigine = $_FILES['monfichier']['name'];
$elementsChemin = pathinfo($nomOrigine);
$extensionFichier = $elementsChemin['extension'];
$extensionsAutorisees = array("pdf", "docx", "zip");

try
	{
        if (!(in_array($extensionFichier, $extensionsAutorisees))) {
            echo "Le fichier n'a pas l'extension attendue";
            } else {    
    // Copie dans le repertoire du script avec un nom
    // incluant l'heure a la seconde pres 
                $repertoireDestination = dirname(__FILE__)."/";
                $nomDestination = "fichier_du_".date("YmdHis").".".$extensionFichier;

                if (move_uploaded_file($_FILES["monfichier"]["tmp_name"], 
                                     $repertoireDestination.$nomDestination)) {
                echo "Le fichier temporaire ".$_FILES["monfichier"]["tmp_name"].
                " a été déplacé vers ".$repertoireDestination.$nomDestination;
             } else {
                 echo "Le fichier n'a pas été uploadé (trop gros ?) ou ".
                "Le déplacement du fichier temporaire a échoué".
                " vérifiez l'existence du répertoire ".$repertoireDestination;
     }
}   

}

catch(PDOException $e)
	{
	  	// On termine le script en affichant le num de l'erreur ainsi que le message 
    	die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}




function afficheJoueursSelonFiltre($bd,$filtres,$ordre)
{
	try
	{
		
		$sql = 'SELECT * FROM joueursEchec';
		if(isset($filtres[':signeNaissance']))
		{
			$sql .= ' WHERE Naissance ';
			if($filtres[':signeNaissance']==-1)
				$sql.= ' <= ';
			else if ($filtres[':signeNaissance']==0)
				$sql .= ' = ' ;
			else
				$sql .= ' >= ' ;
			$sql .= ':naissance';
			unset($filtres[':signeNaissance']);
		}
		if(isset($filtres[':pays']))
		{
			if(isset($filtres[':naissance']))
				$sql .= ' AND ';
			else
			 	$sql .= ' WHERE ';
			$sql .= 'Pays = :pays';
		}
		if($ordre=='Nom')
			$sql .= ' ORDER BY Nom, Prénom' ;
		else
			$sql .= ' ORDER BY ' . $ordre . ' DESC';
			
		$req = $bd->prepare($sql);
		foreach($filtres as $c => $v)
			$req->bindValue($c,$v);
		$req->execute();
	
		echo '<table>' . "\n";
		$res = $req->fetch(PDO::FETCH_ASSOC);

		//Il y a au moins une ligne
		if($res)
		{
			//On affiche les en-têtes
			echo '<tr>'."\n";
			foreach($res as $c => $v)
				echo '<th>' . $c . '</th>';
			echo '<th class="sansBordure"></th></tr>'."\n";		
				 
	 		do
			{
				echo '<tr>'."\n";
				foreach($res as $v)
					echo '<td>' . $v . '</td>';
				echo '<td class="sansBordure"><a href="supprimer.php?nom='.urlencode($res['Nom']).'&amp;prenom='. urlencode($res['Prénom']).'"><img src="supprimer.png" alt="suppr"/></a></td></tr>'."\n";
			}while($res = $req->fetch(PDO::FETCH_ASSOC));
		}
		else
			echo '<p>Aucun joueur dans la base de données </p>';
	}
	catch(PDOException $e)
	{
	  	// On termine le script en affichant le num de l'erreur ainsi que le message 
    	die('<p> Erreur PDO[' .$e->getCode().'] : ' .$e->getMessage() . '</p>');
	}	
	echo '</table>'."\n";
}

?>

<?php
$dossier = 'upload/';
$fichier = basename($_FILES['avatar']['name']);
$taille_maxi = 100000;
$taille = filesize($_FILES['avatar']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['avatar']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
?>




	