<?php

class Graphique {

    private $selectCountCo;
    private $selectJusteCo;

    public function __construct($db) {
        $this->db = $db;
        $this->selectCountCo = $db->prepare("SELECT t1.email, (SELECT COUNT(*) FROM connexions t2 WHERE t2.emailco = t1.email) as nombredeco FROM utilisateurppe1 t1 ORDER by nombredeco desc");
        $this->selectJusteCo = $db->prepare("SELECT emailco, count(*) as nombredeco FROM connexions GROUP BY emailco");
    }

    public function selectCountCo() {
        $liste = $this->selectCountCo->execute();
        if ($this->selectCountCo->errorCode() != 0) {
            print_r($this->selectCountCo->errorInfo());
        }
        return $this->selectCountCo->fetchAll();
    }

    public function selectJusteCo() {
        $liste2 = $this->selectJusteCo->execute();
        if ($this->selectJusteCo->errorCode() != 0) {
            print_r($this->selectJusteCo->errorInfo());
        }
        return $this->selectJusteCo->fetchAll();
    }

    public function top($dataly, $type) {
        $image = null;
        $graph = null;

        if ($type == 'barres3') {
            $axe = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24');
            $graph = $this->barres($dataly, $axe);
        } elseif ($type == 'barres2') {
            $axe = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31');
            $graph = $this->barres($dataly, $axe);
        } elseif ($type == 'barres') {
            $axe = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
            $graph = $this->barres($dataly, $axe);
        } else {
            $graph = $this->Pie($dataly);
        }
        if ($graph != null) {

            $gdImgHandler = $graph->Stroke(_IMG_HANDLER);

            ob_start();

            $graph->img->Stream();

            $image_data = ob_get_contents();

            ob_end_clean();

            $image = base64_encode($image_data);
        } else {
            echo 'null';
        }
        return $image;
    }

    public function Barres($data1y, $axe) {

        $graph = new Graph(800, 600, 'auto');
        $graph->SetScale("textlin");

        $theme_class = new UniversalTheme();
        $graph->SetTheme($theme_class);

        $graph->SetBox(false);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($axe);
        $graph->yaxis->HideLine(false);

        $b1plot = new BarPlot($data1y);

        $gbplot = new GroupBarPlot(array($b1plot));

        $graph->Add($gbplot);

        $b1plot->SetColor("white");
        $b1plot->SetFillColor("#b50ffc");

        return $graph;
    }

    public function Pie($data) {

        $graph = new PieGraph(800, 600);

        $graph->SetFrame(false);

        $theme_class = new VividTheme();
        $graph->SetTheme($theme_class);

        $p1 = new PiePlot3D($data);
        $graph->Add($p1);

        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->ExplodeSlice(1);
        return $graph;
    }

}

?>
