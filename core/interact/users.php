<?php
    $sqlite = new PDO('sqlite:private/data.db');
    if(isset($_POST['user'],$_POST['pwd1'],$_POST['pwd2']) && $_SESSION['admin'] == 1){
        $testuser = $sqlite->query('SELECT id FROM users WHERE username=' . $sqlite->quote($_POST['user']));
        $testuser = $testuser->fetch();
        if(!isset($testuser['id']) && $_POST['pwd1'] == $_POST['pwd2']){
            $user = $sqlite->quote(htmlentities($_POST['user']));
            $pass = $sqlite->quote(sha1($_POST['user'] . $_POST['pwd1'] . $_POST['user']));
            $sqlite->query('INSERT INTO users (username,password,admin) VALUES(' . $user . ',' . $pass . ', "0")');   
            header('Location: ../index.php?p=parametres&page=utilisateurs&msg=7');
        }
        else{
            header('Location: ../index.php?p=parametres&page=utilisateurs&msg=4');
        }
    }
    elseif(isset($_GET['deluser']) && is_numeric($_GET['deluser']) && $_SESSION['admin'] == 1){
        $is_admin = $sqlite->query('SELECT id FROM users WHERE id=' . $sqlite->quote($_GET['deluser']) . ' AND admin="0"');
        $is_admin = $is_admin->fetch();
        if(isset($is_admin['id'])){
            $sqlite->query('DELETE FROM users WHERE id=' . $sqlite->quote($_GET['deluser']));    
            $sqlite->query('DELETE FROM feeds WHERE user_id=' . $sqlite->quote($_GET['deluser']));    
            $sqlite->query('DELETE FROM items WHERE user_id=' . $sqlite->quote($_GET['deluser']));    
        }
        header('Location: ../index.php?p=parametres&page=utilisateurs&msg=6');
    }
    else{
        header('Location: ../index.php?p=parametres&page=utilisateurs&msg=2');
    }
?>