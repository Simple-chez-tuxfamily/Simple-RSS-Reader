<?php
    session_start();
    $sqlite = new PDO('sqlite:../include/data.db');
    if(isset($_POST['pwd1'],$_POST['pwd2'],$_POST['pwd3'],$_SESSION['uname'])){
        $pass = $sqlite->quote(sha1($_SESSION['uname'] . $_POST['pwd1'] . $_SESSION['uname']));
        $query = $sqlite->query('SELECT id FROM users WHERE password=' . $pass);
        $cpwd = $query->fetch();
        if($_POST['pwd2'] == $_POST['pwd3'] && isset($cpwd['id'])){
            $pass = $sqlite->quote(sha1($_SESSION['uname'] . $_POST['pwd2'] . $_SESSION['uname']));
            $sqlite->query('UPDATE users SET password=' . $pass . ' WHERE id="' . $_SESSION['id'] . '"');
            header('Location: index.php?page=compte&msg=3');
        }
        else{
            header('Location: index.php?page=compte&msg=4');
        }
    }
    elseif(isset($_GET['theme'],$_SESSION['id'])){
        $sqlite->query('UPDATE users SET theme=' . $sqlite->quote($_GET['theme']) . ' WHERE id="' . $_SESSION['id'] . '"');   
        $_SESSION['theme'] = $_GET['theme'];
        header('Location: index.php?page=compte&msg=5');
    }
    else{
        header('Location: index.php?page=compte&msg=2');
    }
?>