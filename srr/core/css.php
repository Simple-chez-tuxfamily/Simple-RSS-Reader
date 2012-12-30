<?php
    /*
     * css.php est le *SEUL* fichier css à charger. Il s'occupe de minifier le fichier css du thème de l'utilisateur
    */
    
    session_start();
    
    if(!isset($_SESSION['theme'])){
        header('HTTP/1.0 404 Not Found');
        exit(0);
    }
    
    $css = file_get_contents('../themes/' . $_SESSION['theme'] . '/template.css');
    
    $mauvaises_choses = array(
      "\r",
      "\t",
      "\n\n",
      "\n",
      '  ',
      '   ',
    );
    
    $css = preg_replace('/(\/\*([\s\S]*?)\*\/)|(\/\/(.*)$)/m', '', $css);
    $css = str_replace($mauvaises_choses, '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(', ', ',', $css);
    $css = str_replace(';}', '}', $css);
    
    header('Content-type: text/css');
    header('Expires: ' + gmdate('D, d M Y H:i:s', time() + 604800) . ' GMT'); // On cache pour une semaine
    header('Pragma: cache'); // On cache pour une semaine
    header('Cache-Control: max-age=604800'); // On cache pour une semaine
    echo $css;
?>