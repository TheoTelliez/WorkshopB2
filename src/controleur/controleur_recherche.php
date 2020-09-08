<?php

function actionRecherche($twig, $db) {
    $form = array();
    $coder = new Coder($db);


    if (isset($_POST['btRecherche'])) {

        $recherche = $_POST['inputRecherche'];

        $listerecherche = $coder->rechercher($recherche);
    }

    echo $twig->render('recherche.html.twig', array('form' => $form, 'listerecherche' => $listerecherche));
}
?>

