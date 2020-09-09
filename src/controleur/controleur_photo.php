<?php

function actionModifPhoto($twig, $db) {
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
        if (isset($_POST['btPhotoSupp'])) {
            $utilisateur = new Utilisateurppe1($db);
            $email = $_POST['email'];
            $photo =  'vide.jpg';
            $exec = $utilisateur->updateuniquementphoto($email, $photo);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Échec de la suppression';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Suppression  réussie';
            }
        }
        if (isset($_POST['btPhotoValider'])) {
            $utilisateur = new Utilisateurppe1($db);
            $email = $_POST['email'];
            $photo = NULL;
            if (isset($_FILES['photo'])) {
                if (!empty($_FILES['photo']['name'])) {
                    $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                    $taille_max = 500000;
                    $dest_dossier = '/var/www/html/symfony4-4059/public/WorkshopB2/web/images/';
                    if (!in_array(substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok)) {
                        echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                    } else {
                        if (file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo']
                                        ['tmp_name'])) > $taille_max) {
                            echo 'Votre fichier doit faire moins de 500Ko !';
                        } else {
                            $photo = basename($_FILES['photo']['name']);
                            // enlever les accents

                            $photo = strtr($photo, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                            // remplacer les caractères autres que lettres, chiffres et point par _
                            $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                            // copie du fichier
                            move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $photo);
                        }
                    }
                }
            }
            $exec = $utilisateur->updateuniquementphoto($email, $photo);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Échec du changement de photo';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Changement de photo réussi';
            }
        }
    }
    echo $twig->render('modifphoto.html.twig', array('form' => $form));
}

?>
