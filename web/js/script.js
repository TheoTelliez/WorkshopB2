//SCRIPT POUR LES STATISTIQUES : 


$(document).ready(function () {

    // On cache tout pour commencer : 

    // Pour année : 

    $("#selectannee").hide();
    $("#afficherannee").hide();
    $("#graph").hide();

    // Pour mois : 

    $("#selectannee2").hide();
    $("#selectmois").hide();
    $("#affichermois").hide();
    $("#graph2").hide();

    //Pour jours : 

    $("#selectannee3").hide();
    $("#selectmois1").hide();
    $("#selectjour").hide();
    $("#afficherjour").hide();
    $("#graph3").hide();



// Pour choisir l'année X uniquement : 

    // change(function () : 

    $("#selectannee").change(function () {
        window.location = "index.php?page=stats&annee=" + $("#selectannee").val() + "&mois=01&jour=01";

        // Pour année : 

        $("#graph").show("slow");

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#selectannee3").hide();
        $("#selectmois1").hide();
        $("#selectjour").hide();
        $("#afficherjour").hide();
        $("#graph3").hide();

    });

    // #BT ... :

    $("#btannee").click(function () {

        // Pour année : 

        $("#selectannee").show("slow");
        $("#afficherannee").show("slow");
        $("#graph").show("slow");

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#selectannee3").hide();
        $("#selectmois1").hide();
        $("#selectjour").hide();
        $("#afficherjour").hide();
        $("#graph3").hide();

    });



// Pour choisir l'année X et le mois X :

    // change(function () : 

    $("#selectannee2").change(function () {
        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#graph2").show("slow");

        //Pour jours : 

        $("#selectannee3").hide();
        $("#selectmois1").hide();
        $("#selectjour").hide();
        $("#afficherjour").hide();
        $("#graph3").hide();

    });


    $("#selectmois").change(function () {
        window.location = "index.php?page=stats&annee=" + $("#selectannee2").val() + "&mois=" + $("#selectmois").val() + "&jour=01";
        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#graph2").show("slow");

        //Pour jours : 

        $("#selectannee3").hide();
        $("#selectmois1").hide();
        $("#selectjour").hide();
        $("#afficherjour").hide();
        $("#graph3").hide();


    });

    // #BT ... :

    $("#btmois").click(function () {

        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#selectannee2").show("slow");
        $("#selectmois").show("slow");
        $("#affichermois").show("slow");
        $("#graph2").show("slow");

        //Pour jours : 

        $("#selectannee3").hide();
        $("#selectmois1").hide();
        $("#selectjour").hide();
        $("#afficherjour").hide();
        $("#graph3").hide();
    });



// Pour choisir l'année X et le mois X et le jour X :


    // change(function () : 

    $("#selectannee3").change(function () {
        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#graph3").show("slow");

    });


    $("#selectmois1").change(function () {

        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#afficherjour").show("slow");
        $("#graph3").show("slow");


    });


    $("#selectjour").change(function () {
        window.location = "index.php?page=stats&annee=" + $("#selectannee3").val() + "&mois=" + $("#selectmois1").val() + "&jour=" + $("#selectjour").val();
        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#graph3").show("slow");
    });


    // #BT ... :

    $("#btjour").click(function () {

        // Pour année : 

        $("#selectannee").hide();
        $("#afficherannee").hide();
        $("#graph").hide();

        // Pour mois : 

        $("#selectannee2").hide();
        $("#selectmois").hide();
        $("#affichermois").hide();
        $("#graph2").hide();

        //Pour jours : 

        $("#selectannee3").show("slow");
        $("#selectmois1").show("slow");
        $("#selectjour").show("slow");
        $("#afficherjour").show("slow");
        $("#graph3").show("slow");
    });


});

