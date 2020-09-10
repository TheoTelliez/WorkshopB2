<?php

function actionLogsAdmin($twig, $db) {
    $form = array();
    $logs = new Connexion($db);
    $limite = 10; // On règle ici la limite d'affichages dans le tableau
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $logs->selectCount();
    $nb = $r['nb'];


    $liste = $logs->selectLimit($inf, $limite); // Bien faire attention au fait que le $liste doit apparaitre une seule fois avec le selectLimit et pas le select (on doit l'enlever)
    $form['nbpages'] = ceil($nb / $limite);
    echo $twig->render('logsadmin.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionLogsDev($twig, $db) {
    $form = array();
    $coder = new Coder($db);
    $utilisateur = new Utilisateurppe1($db);



    if (isset($_GET['id'])) {
        $exec = $coder->delete($_GET['id'], $_SESSION['login']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table coder';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Language supprimé avec succès';
        }
    }

    $liste = $utilisateur->selectbyemailcoder($_SESSION['login']);

    echo $twig->render('logsdev.html.twig', array('form' => $form, 'liste' => $liste));
}


?>