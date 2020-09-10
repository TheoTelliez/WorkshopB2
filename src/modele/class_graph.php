<?php

class Graphique {

    private $selectCountCo;
    private $selectJusteCo;

    public function __construct($db) {
        $this->db = $db;
        $this->selectCountCo = $db->prepare("SELECT t1.email, (SELECT COUNT(*) FROM connexions t2 WHERE t2.emailco = t1.email) as nombredeco FROM utilisateurppe1 t1 ORDER by nombredeco desc");
        $this->selectJusteCo = $db->prepare("SELECT emailco, count(*) as nombredeco FROM connexions GROUP BY emailco");
        $this->selectJusteCon = $db->prepare("SELECT nom FROM `language` WHERE 1");

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

    public function selectJusteCon() {
        $liste3 = $this->selectJusteCon->execute();
        if ($this->selectJusteCon->errorCode() != 0) {
            print_r($this->selectJusteCon->errorInfo());
        }
        return $this->selectJusteCon->fetchAll();
    }


    public function top($dataly, $type) {
        $image = null;
        $graph = null;

        if ($type == 'barres2') {
            $axe = array('1', '2', '3');
            $graph = $this->barres($dataly, $axe);
        } elseif ($type == 'barres') {
            $axe = array('1', '2', '3');
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



}

?>
