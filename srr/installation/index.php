<!DOCTYPE html>
<html>
    <head>
        <title>Installation - Simple RSS Reader</title>
        <meta http-equiv=Content-Type content="text/html; charset=utf-8" />
        <style type="text/css">
            body{
                background:#f5f5f5;
                font-family:sans-serif;
                font-size:12px;
            }
            label{
                display:block;
                width:150px;
                float:left;
                margin:3px 0;
            }
            label,input{
                height:16px;
                margin:3px 0;
            }
            input[type="submit"]{
                height:26px;
                cursor:pointer;
            }
        </style>
    </head>
    <body>
        <h1>Installation</h1>
            <p>Pour installer Simple RSS Reader, complétez simplement le formulaire ci-dessous. Si vous migrez depuis la version précédente, pensez à sauvegarder la liste des flux! Pensez également à supprimer le dossier "installation" après avoir installé Simple RSS Reader!</p>
            <form action="install.php" method="post">
                <label for="pseudo">Nom d'utilisateur:</label> <input type="text" name="pseudo" /><br />
                <label for="pwd1">Mot de passe:</label> <input type="password" name="pwd1" /><br />
                <label for="pwd2">Mot de passe (encore):</label> <input type="password" name="pwd2" /><br /><br />
                <input type="submit" value="Créer mon compte" />
            </form>
    </body>
</html>