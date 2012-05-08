<?php
session_start();
ini_set('display_errors','On');
error_reporting(0);

/* XML File */
$xml = file_get_contents($_FILES['file']['tmp_name']);
$file = simplexml_load_string($xml);

/* SQLite3 */
$sqlite = new PDO('sqlite:../include/data.db');

if(!$file):
	header('Location: index.php?page=impexp&msg=0');
else:

	foreach($file->body->outline as $entry):
		if(empty($entry['htmlUrl'])):
			foreach($entry as $flux):
			
				// If there is already an feed with the same url in the BDD
				$already_exist = $sqlite->query('SELECT count(*) AS nb_sites FROM feeds WHERE user_id = '.$sqlite->quote($_SESSION['id']).' AND url = '.$sqlite->quote($flux['htmlUrl']));
				$already_exist = $already_exist->fetch();
		
				if(intval($already_exist['nb_sites']) == 0):
		
					$maxid = $sqlite->query('SELECT max(id) FROM feeds');
					$maxid = $maxid->fetch();
					$maxid = $maxid[0] + 1;
					$maxid = $sqlite->quote($maxid); 
					$title = (empty($flux['title'])) ? $sqlite->quote($flux['text']) : $sqlite->quote($flux['title']);
					$url = $sqlite->quote($flux['htmlUrl']);
			
			
					$sqlite->query('INSERT INTO feeds VALUES('.$maxid.', '.$title.', '.$url.', "0", '.$sqlite->quote($_SESSION['id']).')');
			
				endif;	

			
			endforeach;
		
		else:
			// If there is already an feed with the same url in the BDD
			$already_exist = $sqlite->query('SELECT count(*) AS nb_sites FROM feeds WHERE user_id = '.$sqlite->quote($_SESSION['id']).' AND url = '.$sqlite->quote($entry['htmlUrl']));
			$already_exist = $already_exist->fetch();
		
			if(intval($already_exist['nb_sites']) == 0):
		
				$maxid = $sqlite->query('SELECT max(id) FROM feeds');
				$maxid = $maxid->fetch();
				$maxid = $maxid[0] + 1;
				$maxid = $sqlite->quote($maxid);
				$title = (empty($entry['title'])) ? $sqlite->quote($entry['text']) : $sqlite->quote($entry['title']);
				$url = $sqlite->quote($entry['htmlUrl']);
			
			
				$sqlite->query('INSERT INTO feeds VALUES('.$maxid.', '.$title.', '.$url.', "0", '.$sqlite->quote($_SESSION['id']).')');
			
			endif;	
		endif;
	endforeach;
	header('Location: index.php?page=impexp&msg=1');
	
endif;
?>