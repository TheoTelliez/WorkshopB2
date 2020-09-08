<?php
/* Définit la largeur et la hauteur en proportion du logo PHP */
$width = 400;
$height = 210;

/* Crée un objet Imagick avec une toile transparent */
$img = new Imagick();
$img->newImage($width, $height, new ImagickPixel('transparent'));

/* Nouvelle instance ImagickDraw pour dessiner l'ellipse */
$draw = new ImagickDraw();
/* Définit la couleur violette pour remplir l'ellipse */
$draw->setFillColor('#777bb4');
/* Définit les dimensions de l'ellipse */
$draw->ellipse($width / 2, $height / 2, $width / 2, $height / 2, 0, 360);
/* Dessine l'ellipse dans la toile */
$img->drawImage($draw);

/* Réinitialise la couleur de remplissage, passant du violet au noir pour le texte (note : nous ré-utilisons l'objet ImagickDraw) */
$draw->setFillColor('black');
/* Définit à blanc la couleur du trait de la bordure */
$draw->setStrokeColor('white');
/* Rend plus fin le trait de la bordure */
$draw->setStrokeWidth(2);
/* Définit le crénage de la police (une valeur négative signifie que les lettres sont proches les unes des autres) */
$draw->setTextKerning(-8);
/* Définit la police et sa taille à utiliser dans le logo PHP */
//$draw->setFont('fontawesome-social-webfont.ttf');
$draw->setFontSize(150);
/* On centre le texte horizontalement et verticalement */
$draw->setGravity(Imagick::GRAVITY_CENTER);

/* Ajout de "php" au centre, avec une position en Y de -10 dans la toile (à l'intérieur de l'ellipse) */
$img->annotateImage($draw, 0, -10, 0, 'php');
$img->setImageFormat('png');

/* On définit l'en-tête approprié pour le PNG et on affiche l'image */
header('Content-Type: image/png');
echo $img;
?>