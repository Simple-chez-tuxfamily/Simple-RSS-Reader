<?php
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');
    if(isset($_POST['user'],$_POST['pwd1'],$_POST['pwd2']) && $_SESSION['admin'] == 1){
        $testuser = $sqlite->query('SELECT id FROM users WHERE username=' . $sqlite->quote($_POST['user']));
        $testuser = $testuser->fetch();
        if(!isset($testuser['id']) && $_POST['pwd1'] == $_POST['pwd2']){
            $maxid = $sqlite->query('SELECT max(id) FROM users');
            $maxid = $maxid->fetch();
            $maxid = $maxid[0] + 1;
            $user = $sqlite->quote($_POST['user']);
            $pass = $sqlite->quote(sha1($_POST['user'] . $_POST['pwd1'] . $_POST['user']));
            $sqlite->query('INSERT INTO users VALUES(' . $maxid . ',' . $user . ',' . $pass . ',"0","defaut")');   
        }
        header('Location: index.php');
    }
    elseif(isset($_GET['deluser']) && is_numeric($_GET['deluser']) && $_SESSION['admin'] == 1){
        $sqlite->query('DELETE FROM users WHERE id="' . $_GET['deluser'] . '" AND admin="0"');    
        header('Location: index.php');
    }
    else{
        header('Location: index.php');
    }
?>