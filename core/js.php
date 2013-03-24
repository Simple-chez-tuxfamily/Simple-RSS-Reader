<?php
    /*
     * js.php est le *SEUL* fichier js à charger. Il s'occupe d'inclure tout les scripts js présents dans javascript/ + du thème utilisateur et de les minifier légèrement
    */
    
    session_start();
    if(!isset($_SESSION['token'])) $_SESSION['token'] = '';
    
    $javascript = null;
    
    $repertoire = opendir('javascript');
    while($contenu = readdir($repertoire)){
        if(!is_dir($contenu))
            $javascript .= file_get_contents('javascript/' . $contenu);
    }
    closedir($repertoire);
    
    if(file_exists('../theme/template.js'))
        $javascript .= file_get_contents('../themes/' . $_SESSION['theme'] . '/template.js');
    
    $mauvaises_choses = array(
      "\r",
      "\t",
      "\n\n",
      '  ',
      '   ',
    );
    
    $javascript = preg_replace('(// .+)', '', $javascript);
    $javascript = preg_replace('/(\/\*([\s\S]*?)\*\/)|(\/\/(.*)$)/m', '', $javascript);
    $javascript = str_replace($mauvaises_choses, '', $javascript);
    
    header('Content-type: text/javascript');
    echo str_replace('[PHP_ADD_TOKEN]', $_SESSION['token'], $javascript);
?>