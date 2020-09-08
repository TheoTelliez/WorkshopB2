<?php

function actionStats($twig, $db) {
    $graph = new Graphique($db);
    $liste = $graph->selectCountCo();
    $liste2 = $graph->selectJusteCo();

    $form = array();

    $afficherannee = $_GET['annee']; //Pour l'affichage des années
    $form['afficherannee'] = $afficherannee;

    $affichermois = $_GET['mois']; //Pour l'affichage des mois
    $form['affichermois'] = $affichermois;

    $afficherjour = $_GET['jour']; //Pour l'affichage des jours
    $form['afficherjour'] = $afficherjour;



    $datedebutannee = $_GET['annee'] . '-01-01 00:00:00';
    $datefinannee = $_GET['annee'] . '-12-31 23:59:59';

    $datedebutmois = $_GET['annee'] . '-' . $_GET['mois'] . '-01 00:00:00';
    $datefinmois = $_GET['annee'] . '-' . $_GET['mois'] . '-31 23:59:59';

    $datedebutjour = $_GET['annee'] . '-' . $_GET['mois'] . '-' . $_GET['jour'] . '-00:00:00';
    $datefinjour = $_GET['annee'] . '-' . $_GET['mois'] . '-' . $_GET['jour'] . '-23:59:59';

    $connexion = new Connexion($db);
    $test = $connexion->selectAnnee($datedebutannee, $datefinannee);

    $test2 = $connexion->selectMois($datedebutmois, $datefinmois);

    $test3 = $connexion->selectJour($datedebutjour, $datefinjour);



    $tableau = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); //12 fois 0 pour 12 mois
    $tableau2 = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); //31 fois 0 pour 31 jours
    $tableau3 = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0); //24 fois 0 pour 24 heures


    foreach ($test as $uneligne) {
        $tableau [$uneligne['Mois'] - 1] = $uneligne['NombreDeCoParMois'];
    }

    foreach ($test2 as $uneligne2) {
        $tableau2 [$uneligne2['Jours'] - 1] = $uneligne2['NombreDeCoParJours'];
    }
    
    foreach ($test3 as $uneligne3) {
        $tableau3 [$uneligne3['Heures']] = $uneligne3['NombreDeCoParHeure'];
    }


    $r = $graph->top($tableau, 'barres'); //Pour les mois
    $r2 = $graph->top($tableau2, 'barres2'); //Pour les jours
    $r3 = $graph->top($tableau3, 'barres3'); //Pour les heures


    echo $twig->render('stats.html.twig', array('graph' => $r, 'graph2' => $r2, 'graph3' => $r3, 'form' => $form,  'liste' => $liste));
}

?>