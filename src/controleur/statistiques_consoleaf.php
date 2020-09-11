<?php
$utilisateur = $_GET["utilisateur"];
$connect = mysqli_connect("localhost", "login4059", "kFILYMNLotHlbgo", "dblogin4059WORKSHOP");   // équivalent du fichier config
$query = "SELECT *, c.hpj*l.watt as consojour FROM language l, coder c WHERE l.id=c.idLanguage and emailcoder='$utilisateur'"; //équivalent de la classe dans le MVC
$result = mysqli_query($connect, $query);  //données qui sont normalement transmises
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come
    *after* these tags -->
    <meta name="author" content="">
    <title> ConsoLeaf - Statistiques</title>
    <link href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900|Quicksand:400,700|Questrial" rel="stylesheet" />
    <link href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/css/fonts.css" rel="stylesheet" type="text/css" media="all" />
    <link href="https://www.boracay-presse.com/wp-content/uploads/2018/10/Picto-boracay-feuille-01.png" rel="icon" /> <!-- Cette ligne c'est pour le logo dans la barre de navigation du navigateur -->
    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->
    <link href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/css/style-signin.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/2f4aa51ca0.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart()
        {
            var data = google.visualization.arrayToDataTable([
                ['idLanguage', 'Conso'],
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "['" . $row["nom"] . "', " . $row["consojour"] . "],";
                }
                ?>
            ]);
            var options = {
                <!--                title: 'Pourcentages de co par emails', -->
                backgroundColor: 'white',
                is3D:true,
                legend:{position: 'right'},
                //pieHole: 0.4
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>





</head>
<body>
<nav style="background-color: #3c763d;">
    <div id="logo" style="text-align: center">
        <span class="icon icon-leaf"></span>
        <h1><a href="">ConsoLeaf</a></h1>
    </div>
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <center>
            <ul id="menu" class="nav navbar-nav">
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php">Accueil</a></li>

                <li class="dropdown">
                    <a class="dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" ariahaspopup="
                                           true" aria-expanded="false">Administration</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=ajoutequipement">Ajout équipement</a></li>
                    </ul>
                </li>

                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=apropos">À propos</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=mentions">Mentions légales</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=contact">Contact</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=moncompte&email=<?php echo $utilisateur;?>">Mon domicile</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=econo">Astuces éco</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/index.php?page=deconnexion">Se déconnecter</a></li>

            </ul>
            <form class="navbar-form navbar-right" action="index.php?page=recherche" method="post"
                  enctype="application/x-www-form-urlencoded">
                <input id="inputRecherche" name="inputRecherche" class="form-control mr-sm-2" type="search" placeholder="Rechercher" arialabel="Rechercher">
                <button class="btn btn-outline-success my-2 my-sm-0" id="btRecherche" name="btRecherche" type="submit">OK</button>
            </form>
    </div> <!-- Ici on ne sait pas pourquoi ça se met en rouge dans le code source parce que la balise est bien fermée ! -->
</nav>




<div class="wrapper" style="text-align: center;" >
    <br /><br />
<h2>Statistiques de ma consommation :</h2>




<div>
    <div id="piechart" style="height: 600px; margin-left: 5%; margin-right: 5%;"></div>
</div>

</div>




<div id="copyright">
    <p>&copy; Projet Workshop B2. Tous droits réservés. | Photos par <a href="http://fotogrph.com/">Fotogrph</a> | Modèle par <a href="http://templated.co" rel="nofollow">TEMPLATED</a>.</p>
    <ul class="contact">
        <li><a href="" class="icon icon-facebook"><span>Facebook</span></a></li>
        <li><a href="" class="icon icon-twitter"><span>Twitter</span></a></li>
        <li><a href="" class="icon icon-instagram"><span>Instagram</span></a></li>
        <li><a href="" class="icon icon-github"><span>GitHub</span></a></li>
    </ul>
</div>
{% endblock %}
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-3.2.1.min.js"><\/script>')</script>
<script src="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/js/bootstrap.min.js"></script>
<script src="http://serveur1.arras-sio.com/symfony4-4059/WorkshopB2/web/js/script.js"></script>
</body>
</html>