<?php
    if(isset($_POST['pseudo'],$_POST['pwd1'],$_POST['pwd2'])){
        if($_POST['pwd1'] == $_POST['pwd2']){
            $sqlite = new PDO('sqlite:../include/data.db');
            $user = $sqlite->quote($_POST['pseudo']);
            $pass = $sqlite->quote(sha1($_POST['pseudo'] . $_POST['pwd1'] . $_POST['pseudo']));
            $sqlite->query('INSERT INTO users VALUES("0",' . $user . ',' . $pass . ',"1","defaut")');   
            header('Location: ../index.php');
        }
        else{
            header('Location: index.php');
        }
    }
    else{
        header('Location: index.php');
    }
?>