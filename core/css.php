<?php
    /*
     * css.php est le *SEUL* fichier css à charger. Il s'occupe de minifier le fichier css du thème de l'utilisateur
    */
    
    $css = file_get_contents('../theme/template.css');
    
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
    echo $css;
?>