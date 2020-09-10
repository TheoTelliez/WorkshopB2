<?php

function actionAdminLanguages($twig, $db) {
    $form = array();
    $lang = new Language($db);
    
    if (isset($_POST['btLang'])) {
        $inputLang = $_POST['inputLang'];
        $inputWatt = $_POST['inputWatt'];
        $form['valide'] = true;
        $lang = new Language($db);
        $exec = $lang->insert($inputLang, $inputWatt);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table language ';
        } else
            $form['message'] = 'Insertion dans la table type validée';
    }
    
    if (isset($_GET['id'])) {
        $exec = $lang->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table coder';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Language supprimé avec succès';
        }
    }
    
    
    $liste = $lang->select();
    echo $twig->render('ajoutlanguages.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionLanguages($twig, $db) {
    $form = array();
    $lang = new Language($db);
    $coder = new Coder($db);


    $listeld = $lang->select();
    $listeml = $coder->selectByEmail($_SESSION['login']);

    $t = array();
    foreach ($listeld as $liml) {
        $trouve = 0;
        foreach ($listeml as $lild) {

            if ($lild[0] == $liml[0]) {
                $trouve = 0;

            }
        }
        if ($trouve == 0) {

            $v['id'] = $liml['id'];
            $v['nom'] = $liml['nom'];
            $v['watt'] = $liml['watt'];
            $t[] = $v;
        }
    }
  
    echo $twig->render('languages.html.twig', array('form' => $form, 'listeld' => $t, 'listeml' => $listeml));
}


function actionModifLanguages($twig, $db) {
    $form = array();
       
    if (isset($_GET['id'])) {
        $lang = new Language($db);
        $unLang = $lang->selectByIdLang($_GET['id']);
        if ($unLang != null) {
            $form['langage'] = $unLang;
            
        } else {
            $form['message'] = 'Langage incorrect';
        }
        
    } else {
        if (isset($_POST['btModifLang'])) {
            $lang = new Language($db);
            $unLang = $lang->selectByIdLang($_POST['idlangage']);
            $nom = $_POST['inputModifLang'];
            $watt = $_POST['inputModifWatt'];
            $id = $_POST['idlangage'];
            $form['idlangage'] = $unLang;
            $exec = $lang->update($nom, $id, $watt);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Échec de la modification';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }
        } else {
            $form['message'] = 'Langage non précisé';
        }
    }
    
    echo $twig->render('modiflanguages.html.twig', array('form' => $form));
}


function actionModifConso($twig, $db) {
    $form = array();




    if (isset($_GET['id'])) {
        $language = new Language($db);
        $unLang = $language->selectByIdLang($_GET['id']);
        if ($unLang != null) {
            $form['language'] = $unLang;
        }
    }
    $coder = new Coder($db);
    $listeconso = $coder->selectconso($_SESSION['login'], $_GET['id']);

    if (isset($_POST['btModifConsoVide'])) {

        $coder = new Coder($db);

        $hpj = $_POST['inputHPJ'];
        $jpa = $_POST['inputJPA'];

        $form['coder'] = $coder;


        $idlang = $_POST['idlang'];

        $emailcoder = $_SESSION['login'];




        #INSERT
        $exec = $coder->insert($idlang, $emailcoder, $hpj, $jpa);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }


    } else {
        $form['message'] = 'Equipement non précisé';
    }



    if (isset($_POST['btModifConso'])) {

        $coder = new Coder($db);

        $hpj = $_POST['inputHPJ'];
        $jpa = $_POST['inputJPA'];

        $form['coder'] = $coder;


        $idlang = $_POST['idlang'];

        $emailcoder = $_SESSION['login'];




        #INSERT
        $exec = $coder->updateconso($idlang, $emailcoder, $hpj, $jpa);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la modification';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification réussie';
        }

    } else {
        $form['message'] = 'Equipement non précisé';
    }







    echo $twig->render('modifconso.html.twig', array('form' => $form, 'listeconso' => $listeconso));
}

?>