<?php

/* XML File */
$xml = file_get_contents($_FILES['file']['tmp_name']);
$file = simplexml_load_string($xml);

/* SQLite3 */
$sqlite = new PDO('sqlite:private/data.db');

if(!$file):
	header('Location: ../index.php?p=parametres&page=impexp&msg=0');
else:

	foreach($file->body->outline as $entry):
		if(empty($entry['xmlUrl'])):
			foreach($entry as $flux):
			
				// If there is already an feed with the same url in the BDD
				$already_exist = $sqlite->query('SELECT count(*) AS nb_sites FROM feeds WHERE user_id = '.$sqlite->quote($_SESSION['id']).' AND url = '.$sqlite->quote($flux['xmlUrl']));
				$already_exist = $already_exist->fetch();
		
				if(intval($already_exist['nb_sites']) == 0): 
					$title = (empty($flux['title'])) ? $sqlite->quote($flux['text']) : $sqlite->quote($flux['title']);
					$url = $sqlite->quote($flux['xmlUrl']);
					$sqlite->query('INSERT INTO feeds (title,url,last_check,user_id,error) VALUES('.$title.', '.$url.', ' . $sqlite->quote(time()) . ', '.$sqlite->quote($_SESSION['id']).', 0)');
			
				endif;	

			
			endforeach;
		
		else:
			// If there is already an feed with the same url in the BDD
			$already_exist = $sqlite->query('SELECT count(*) AS nb_sites FROM feeds WHERE user_id = '.$sqlite->quote($_SESSION['id']).' AND url = '.$sqlite->quote($entry['xmlUrl']));
			$already_exist = $already_exist->fetch();
		
			if(intval($already_exist['nb_sites']) == 0):
		
				$title = (empty($entry['title'])) ? $sqlite->quote($entry['text']) : $sqlite->quote($entry['title']);
				$url = $sqlite->quote($entry['xmlUrl']);
			
			
				$sqlite->query('INSERT INTO feeds (title,url,last_check,user_id,error) VALUES('.$title.', '.$url.', ' . $sqlite->quote(time()) . ', '.$sqlite->quote($_SESSION['id']).', 0)');
			
			endif;	
		endif;
	endforeach;
	header('Location: ../index.php?p=parametres&page=impexp&msg=1');
	
endif;
?>