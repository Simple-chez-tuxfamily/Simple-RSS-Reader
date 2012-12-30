<?php
    /*
     * js.php est le *SEUL* fichier js à charger. Il s'occupe d'inclure tout les scripts js présents dans javascript/ + du thème utilisateur et de les minifier légèrement
    */
    
    session_start();
    
    if(!isset($_SESSION['theme'])){
        header('HTTP/1.0 404 Not Found');
        exit(0);
    }
    
    $javascript = null;
    
    $repertoire = opendir('javascript');
    while($contenu = readdir($repertoire)){
        if(!is_dir($contenu))
            $javascript .= file_get_contents('javascript/' . $contenu);
    }
    closedir($repertoire);
    
    if(file_exists('../themes/' . $_SESSION['theme'] . '/template.js'))
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
    header('Expires: ' + gmdate('D, d M Y H:i:s', time() + 604800) . ' GMT'); // On cache pour une semaine
    header('Pragma: cache'); // On cache pour une semaine
    header('Cache-Control: max-age=604800'); // On cache pour une semaine
    echo $javascript;
?>