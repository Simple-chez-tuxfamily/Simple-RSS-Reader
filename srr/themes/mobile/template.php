<!DOCTYPE html>
<html>
    <head>
        <title>Simple RSS Reader</title>
        <link type="text/css" rel="stylesheet" href="themes/mobile/style.css" />
        <link rel="shortcut icon" type="image/png" href="themes/mobile/images/favicon.png" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0" />
        <link rel="apple-touch-icon" href="themes/mobile/images/favicon.png" />
        <script type="text/javascript" src="themes/mobile/template.js"></script>
    </head>
    <body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);">
        <div id="das_big_message">
                <div id="message_content">
                    <strong>Erreur</strong>
                    <p>Javascript semble être désactivé. Pour pouvoir utiliser Simple RSS Reader, vous devez impérativement activer Javascript dans les préférences de votre navigateur.</p>
                </div>
            </div>
            <header>Simple RSS Reader</header>
            <div id="content"><?php echo $content; ?></div>
            <script type="text/javascript" src="themes/defaut/template.js"></script>
            <script>hide_msg();is_mobile();</script>
    </body>
</html>