<?php

function actionCompte($twig, $db) {
    $form = array();
    $coder = new Coder($db);
    $listeml = $coder->selectByEmail($_SESSION['login']);
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateurppe1($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $form['langages'] = $listeml;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        $form['message'] = 'Utilisateur non précisé';
    }
    echo $twig->render('compte.html.twig', array('form' => $form, 'listeml' => $listeml));
}

function actionModifCompte($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateurppe1($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Roleppe1($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        if (isset($_POST['btModifier'])) {
            $utilisateur = new Utilisateurppe1($db);
            $nom = $_POST['inputModifSurname'];
            $prenom = $_POST['inputModifName'];
            $role = $_POST['role'];
            $email = $_POST['email'];
            $mdp = $_POST['inputModifPassword'];
            $mdp2 = $_POST['inputModifPassword2'];
            if (empty($mdp)) {
                $form['message'] = 'Veuillez rentrer un mot de passe';
            } else {
                if ($mdp != $mdp2) {
                    $form['valide'] = false;
                    $form['message'] = 'Les mots de passe sont différents';
                } else {

                    $exec = $utilisateur->updatesansphoto($email, $role, $nom, $prenom, password_hash($mdp, PASSWORD_DEFAULT));
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = 'Échec de la modification';
                    } else {
                        $form['valide'] = true;
                        $form['message'] = 'Modification réussie';
                    }
                }
            }
        }
    }
    $liste = $utilisateur->select();
    echo $twig->render('modifcompte.html.twig', array('form' => $form, 'liste' => $liste));
}

?>
