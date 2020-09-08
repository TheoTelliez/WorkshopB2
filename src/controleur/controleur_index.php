<?php

function actionAccueil($twig, $db) {
    echo $twig->render('index.html.twig', array());
}

function actionTests($twig, $db) {
    
    
    echo $twig->render('tests.html.twig', array());
}

?>