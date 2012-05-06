<?php
session_start();
ini_set('display_errors','On');
error_reporting(0);

/* XML File */
$xml = file_get_contents($_FILES['file']['tmp_name']);
$file = simplexml_load_string($xml);

/* SQLite3 */
$sqlite = new PDO('sqlite:../include/data.db'); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Paramètres</title>
        <link type="text/css" rel="stylesheet" href="../themes/<?php echo $_SESSION['theme']; ?>/params.css" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>

		<article><h1>Paramètres (<a href="../connexion/disconnect.php">déconnexion</a>)</h1><hr /><fieldset>
<?php
if(!$file):
	echo '<p>Erreur lors de l\'import, le fichier est probablement invalide.<br/>';
	echo '<a href="./">Retour</a></p>';

else:

	foreach($file->body->outline as $entry):
		// If there is already an feed with the same url in the BDD
		$already_exist = $sqlite->query('SELECT count(*) AS nb_sites FROM feeds WHERE user_id = '.$sqlite->quote($_SESSION['id']).' AND url = '.$sqlite->quote($entry['htmlUrl']));
		$already_exist = $already_exist->fetch();
		
		if(intval($already_exist['nb_sites']) == 0):
		
			$maxid = $sqlite->query('SELECT max(id) FROM feeds');
			$maxid = $maxid->fetch();
			$maxid = $maxid[0] + 1;
			$maxid = $sqlite->quote($maxid);
			$title = $sqlite->quote($entry['title']);
			$url = $sqlite->quote($entry['htmlUrl']);
			
			
			$sqlite->query('INSERT INTO feeds VALUES('.$maxid.', '.$title.', '.$url.', "0", '.$sqlite->quote($_SESSION['id']).')');
			
		endif;	
	endforeach;
	
	echo '<p>L\'importation a bien été effectuée.<br/>';
	echo '<a href="./">Retour</a></p>';
	
endif;
?>
		</fieldset></article>		
	</body>
</html>