<?php

function actionAccueil($twig, $db) {
    echo $twig->render('index.html.twig', array());
}

function actionDeconnexion($twig) {
    session_unset();
    session_destroy();
    header("Location:index.php");
}

function actionMentions($twig) {
    echo $twig->render('mentionslegales.html.twig', array());
}

function actionApropos($twig) {
    echo $twig->render('apropos.html.twig', array());
}

function actionEcono($twig) {
    echo $twig->render('econo.html.twig', array());
}

?>