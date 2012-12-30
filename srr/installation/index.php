<!DOCTYPE html>
<html>
    <head>
        <title>Installation - Simple RSS Reader</title>
	<link type="text/css" rel="stylesheet" href="../themes/defaut/template.css" />
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
    </head>
    <body>
        <header>Installation</header>
            <?php
                if(isset($_GET['ok']))
                    echo '<div id="notification" style="background:#8BB548">Simple RSS Reader a été installé avec succès! Supprimez le dossier "installation" pour continuer.</div>';
                elseif(isset($_GET['err']))
                    echo '<div id="notification" style="background:#D63535">Simple RSS Reader a rencontré une erreur lors de l\'installation! Merci de réessayer.</div>';
                else
                    echo '<div id="notification" style="background:#8BB548">Pour installer Simple RSS Reader, complétez le formulaire ci-dessous.</div>';
            ?>
            <br /><br /><form id="connexion" action="install.php" method="post">
                <input type="text" name="pseudo" placeholder="Nom d'utilisateur..." />
                <input type="password" name="pwd1" placeholder="Mot de passe..." />
                <input type="password" name="pwd2" placeholder="Mot de passe (encore)..." />
                <input type="submit" value="Créer mon compte" />
            </form>
    </body>
</html>