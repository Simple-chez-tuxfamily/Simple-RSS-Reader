<!DOCTYPE html>
<html>
    <head>
        <title>RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/mobile/style.css" />
        <link rel="shortcut icon" type="image/png" href="themes/mobile/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <link rel="apple-touch-icon" href="themes/mobile/images/favicon.png" />
        <script type="text/javascript" src="themes/mobile/template.js"></script>
    </head>
    <body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);">
        <?php
            if(!isset($_GET['nobar'])){
                echo '<h1 id="jserror" style="color:#aa0000;margin:5px;">Erreur: Javascript n\'est pas activé!</h1><header id="header"><a href="index.php?p=index">Simple RSS Reader (' . $nonlu . ')</a></header>';
            }
            echo $content;
        ?>
        <script type="text/javascript">
            resize_frame();
            hide_msg();
        </script>
    </body>
</html>