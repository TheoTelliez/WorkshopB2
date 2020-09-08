<?php

function actionInscrire($twig, $db) {
    $form = array();
    $dateinscription = date("d-m-Y");
    $adresse = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    if (isset($_POST['btInscrire'])) {

        $inputEmail = $_POST['inputEmail'];
        $inputPassword = $_POST['inputPassword'];
        $inputPassword2 = $_POST['inputPassword2'];
        $nom = $_POST['inputSurname'];
        $prenom = $_POST['inputName'];
        $role = $_POST['role'];
        $photo = NULL;
        date_default_timezone_set('Europe/Paris');
        $dateinscription = date("Y-m-d"); //Ici le format n'est pas important dans le sens ou on ne le voit pas, et on l'affiche dans le profil en tant que date au bon format.
        $datedernier = date("Y-m-d");


        $numunique = uniqid();


        if (isset($_FILES['photo'])) {
            if (!empty($_FILES['photo']['name'])) {
                $extensions_ok = array('png', 'gif', 'jpg', 'jpeg');
                $taille_max = 500000;
                $dest_dossier = '/var/www/html/symfony4-4059/public/PPE1/web/images/';
                if (!in_array(substr(strrchr($_FILES['photo']['name'], '.'), 1), $extensions_ok)) {
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                } else {
                    if (file_exists($_FILES['photo']['tmp_name']) && (filesize($_FILES['photo']
                                    ['tmp_name'])) > $taille_max) {
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    } else {
                        $photo = basename($_FILES['photo']['name']);
                        // enlever les accents

                        $photo = strtr($photo, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAA
AAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['photo']['tmp_name'], $dest_dossier . $photo);
                    }
                }
            }
        }


        $form['valide'] = true;


        if ($inputPassword != $inputPassword2) {
            $form['valide'] = false;
            $form['message'] = 'Les mots de passe sont différents';
        } else {
            $utilisateur = new Utilisateurppe1($db);

            if ($photo == NULL) {
                $photo = 'vide.jpg'; //fait en sorte que si $photo est vide (lors de l'insertion) alors on mets le vide.png de base
            }



            // DEBUT DE LA COPIE POUR MAIL



            $unUtilisateur = $utilisateur->selectByEmail($_POST['inputEmail']);
            if ($unUtilisateur == null) {
                if ($unUtilisateur != null) {
                    $form['valide'] = false;
                    $form['message'] = 'Utilisateur déja inscrit sur le site PPE';
                } else {
                    header("Location:index.php?page=checkcompte&email=$inputEmail");
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);
                    $to = $inputEmail; // notez la virgule
                    // Sujet
                    $subject = 'Validation de l\'inscription compte';

                    // message
                    $message = '
<html style="width:100%;font-family:arial, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
 <head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>PPE1 :</title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:10px 0px 10px 0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
	padding:0;
}
.ExternalClass {
	width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height:100%;
}
.es-button {
	mso-style-priority:100!important;
	text-decoration:none!important;
}
a[x-apple-data-detectors] {
	color:inherit!important;
	text-decoration:none!important;
	font-size:inherit!important;
	font-family:inherit!important;
	font-weight:inherit!important;
	line-height:inherit!important;
}
.es-desk-hidden {
	display:none;
	float:left;
	overflow:hidden;
	width:0;
	max-height:0;
	line-height:0;
	mso-hide:all;
}
</style> 
 </head> 
 <body style="width:100%;font-family:arial, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
  <div class="es-wrapper-color" style="background-color:#FFFFFF;"> 
   <!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#ffffff" origin="0.5, 0" position="0.5,0"></v:fill>
			</v:background>
		<![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" bgcolor="transparent" style="padding:0;Margin:0;background-color:transparent;"> 
           <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" bgcolor="#ffffff" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;background-image:url(https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/14471579036224795.JPG);background-color:#FFFFFF;background-position:left top;background-repeat:no-repeat;" background="https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/14471579036224795.JPG"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r" width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;"><a target="_blank" href="' . $adresse . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#2CB543;"><img class="adapt-img" src="https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/25751579035521779.JPG" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="560"></a></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"><br><br><br><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica, sans-serif;line-height:21px;color:#333333;text-align:center;">Bonjour, pour valider votre inscription veuillez cliquer <a href="' . $adresse . '?page=validecompte&email=' . $inputEmail . '&id=' . $numunique . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#2CB543;">ici</a></p><br><br><br></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table> 
  </div>  
 </body>
</html>
     ';

                    // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                    $headers[] = 'MIME-Version: 1.0';
                    $headers[] = 'Content-type: text/html; charset=UTF-8';

                    // En-têtes additionnels
//                $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
                    $headers[] = 'From: PPE <validation@ppe.com>';

                    // Envoi
                    mail($to, $subject, $message, implode("\r\n", $headers));


//                    $exec = $utilisateur->updaterecup($datevalide, $numvalide, $inputEmail);
                }
            } else {
                $form['valide'] = false;
                $form['message'] = 'Utilisateur non inscrit sur le site PPE1';
            }



            // FIN DE LA COPIE POUR MAIL









            $exec = $utilisateur->insert($inputEmail, password_hash($inputPassword,
                            PASSWORD_DEFAULT), $role, $nom, $prenom, $photo, $dateinscription, $datedernier, $numunique);

            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème d\'insertion dans la table utilisateur ';
            }
        }






        $form['email'] = $inputEmail;
        $form['role'] = $role;
        $form['datedernier'] = $datedernier;
        $form['numunique'] = $numunique;
    }
    echo $twig->render('inscrire.html.twig', array('form' => $form));
}

function actionCheckCompte($twig, $db) {
    $form = array();
    $inputEmail = $_GET['email'];
    $adresse = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];


    if (isset($_POST['btRenvoieValide'])) {

        $numunique = uniqid();

        date_default_timezone_set('Europe/Paris');
        $utilisateur = new Utilisateurppe1($db);
        $unUtilisateur = $utilisateur->selectByEmail($_POST['inputEmail']);
        if ($unUtilisateur == null) {
            if ($unUtilisateur != null) {
                $form['valide'] = false;
                $form['message'] = 'Utilisateur déja inscrit sur le site PPE';
            } else {
                header("Location:index.php?page=checkcompte&email=$inputEmail");
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                $to = $inputEmail; // notez la virgule
                // Sujet
                $subject = 'Validation de l\'inscription compte';

                // message
                $message = '
<html style="width:100%;font-family:arial, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
 <head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>PPE1 :</title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:30px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:30px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:20px!important; display:block!important; border-width:10px 0px 10px 0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
	padding:0;
}
.ExternalClass {
	width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
	line-height:100%;
}
.es-button {
	mso-style-priority:100!important;
	text-decoration:none!important;
}
a[x-apple-data-detectors] {
	color:inherit!important;
	text-decoration:none!important;
	font-size:inherit!important;
	font-family:inherit!important;
	font-weight:inherit!important;
	line-height:inherit!important;
}
.es-desk-hidden {
	display:none;
	float:left;
	overflow:hidden;
	width:0;
	max-height:0;
	line-height:0;
	mso-hide:all;
}
</style> 
 </head> 
 <body style="width:100%;font-family:arial, helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;"> 
  <div class="es-wrapper-color" style="background-color:#FFFFFF;"> 
   <!--[if gte mso 9]>
			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
				<v:fill type="tile" color="#ffffff" origin="0.5, 0" position="0.5,0"></v:fill>
			</v:background>
		<![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" bgcolor="transparent" style="padding:0;Margin:0;background-color:transparent;"> 
           <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" bgcolor="#ffffff" style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px;background-image:url(https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/14471579036224795.JPG);background-color:#FFFFFF;background-position:left top;background-repeat:no-repeat;" background="https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/14471579036224795.JPG"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r" width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;"><a target="_blank" href="' . $adresse . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#2CB543;"><img class="adapt-img" src="https://funeck.stripocdn.email/content/guids/CABINET_3c9063ad7d67414d03ae9474cb7b1773/images/25751579035521779.JPG" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="560"></a></td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td style="padding:0;Margin:0;"><br><br><br><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, helvetica, sans-serif;line-height:21px;color:#333333;text-align:center;">Bonjour, pour valider votre inscription veuillez cliquer <a href="' . $adresse . '?page=validecompte&email=' . $inputEmail . '&id=' . $numunique . '" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#2CB543;">ici</a></p><br><br><br></td> 
                     </tr> 
                   </table></td> 
                 </tr> 
               </table></td> 
             </tr> 
           </table></td> 
         </tr> 
       </table></td> 
     </tr> 
   </table> 
  </div>  
 </body>
</html>
     ';

                // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=UTF-8';

                // En-têtes additionnels
//                $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
                $headers[] = 'From: PPE <validation@ppe.com>';

                // Envoi
                mail($to, $subject, $message, implode("\r\n", $headers));

                $exec = $utilisateur->updatevalide($numunique, $inputEmail);


//                    $exec = $utilisateur->updaterecup($datevalide, $numvalide, $inputEmail);
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Utilisateur non inscrit sur le site PPE1';
        }

        $form['email'] = $inputEmail;
        $form['numunique'] = $numunique;
    }
    echo $twig->render('checkcompte.html.twig', array('form' => $form));
}

function actionValideCompte($twig, $db) {
    $form = array();



    if (isset($_GET['email'])) {
        $inputEmail = $_GET['email'];
        $inputNumunique = $_GET['id'];
        $form['email'] = $inputEmail;
        $form['numunique'] = $inputNumunique;
        $utilisateur = new Utilisateurppe1($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            if (isset($_GET['id'])) {
                $verifNumunique = $_GET['id'];
                if ($verifNumunique == $unUtilisateur{'numunique'}) {
                    $form['message'] = 'Code de validation correct';
                } else {
                    $form['message'] = 'Code de validation incorrect';
                }
            }
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    }

    if (isset($_POST['btValide'])) {
        $email = $_POST['inputEmail'];
        $utilisateur = new Utilisateurppe1($db);


        date_default_timezone_set('Europe/Paris');
        $datevalide = date("Y-m-d-H:i:s"); //$datevalide = date("d-m-Y-H:i:s");

        $valide = 1;


        $exec = $utilisateur->updatevalidecompte($datevalide, $email, $valide);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Échec de la validation';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Validation réussie';
        }

        $form['datevalide'] = $datevalide;
    }
    echo $twig->render('validecompte.html.twig', array('form' => $form));
}

?>