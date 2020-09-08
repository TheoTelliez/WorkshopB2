<?php

//function actionLanguages($twig) {
//    echo $twig->render('languages.html.twig', array());
//}

function actionAdminLanguages($twig, $db) {
    $form = array();
    $lang = new Language($db);
    
    if (isset($_POST['btLang'])) {
        $inputLang = $_POST['inputLang'];
        $form['valide'] = true;
        $lang = new Language($db);
        $exec = $lang->insert($inputLang);
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
    
    if (isset($_POST['btCoder'])) {
        $cocher = $_POST['cocher'];
        $emailcoder = $_SESSION['login'];
        foreach ($cocher as $idLanguage) {
            $exec = $coder->insert($idLanguage, $emailcoder);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'ajout dans la table coder';
            }
        }
    }

// CE QUE JE RAJOUTE
    
    if (isset($_POST['btSuppListe'])) {
        $cocher = $_POST['cocher'];
        $emailcoder = $_SESSION['login'];
        foreach ($cocher as $idLanguage) {
            $exec = $coder->delete($idLanguage, $emailcoder);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table coder';
            }
        }
    }
    
    if (isset($_GET['id'])) {
        $emailcoder = $_SESSION['login'];
        $exec = $coder->delete($_GET['id'], $emailcoder);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table coder';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Language supprimé avec succès';
        }
    }

// FIN DE CE QUE JE RAJOUTE   
    
    $listeld = $lang->select();
    $listeml = $coder->selectByEmail($_SESSION['login']);
//    $result = array_diff_uassoc($listeld, $listeml, function ($a, $b) {
//        if ($a['id'] === $b['id']) {
//            return 0;
//        }
//        return ($a['id'] > $b['id']) ? 1 : -1;
//    });
    $t = array();
    foreach ($listeld as $liml) {
        $trouve = 0;
        foreach ($listeml as $lild) {
            //var_dump($liml[1]);
//          echo 'compare'.$lild[0].':'.$liml[0];
            if ($lild[0] == $liml[0]) {
                $trouve = 1;
//             echo 'trouvé';
            }
        }
//       echo 'valeur : '. $trouve;
        if ($trouve == 0) {
//           echo 'ajout'.$liml[0];
            $v['id'] = $liml['id'];
            $v['nom'] = $liml['nom'];
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
            $id = $_POST['idlangage'];
            $form['idlangage'] = $unLang;
            $exec = $lang->update($nom, $id);
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

?>