<?php 
session_start();
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="feeds_opml_srr.xml"');

/* SQLite3 */
$sqlite = new PDO('sqlite:../include/data.db');
$query = $sqlite->query('SELECT id,url,title FROM feeds WHERE user_id="' . $_SESSION['id'] . '"');

/* OPML Header & Footer */
$head = <<<OPML
<?xml version="1.0" encoding="UTF-8"?>
<opml version="1.0">
	<head>
		<title>Mes flux</title>
	</head>
	<body>
OPML;
$foot = '</body></opml>';

/* Fetch feeds */
$feeds = '';
while($feed = $query->fetch()){
	$feeds .= '		<outline text="'.htmlspecialchars($feed['title']).'" title="'.htmlspecialchars($feed['title']).'" type="rss" xmlUrl="'. $feed['url'] .'" htmlUrl="'.$feed['url'].'"/>' . "\n"; 
}

echo $head;
echo $feeds;
echo $foot;
?>