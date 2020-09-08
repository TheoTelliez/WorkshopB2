<?php

class Connexion {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $connexion;
    private $select;
    private $selectLimit;
    private $selectLimitEmail;
    private $selectCount;
    private $selectCountEmail;
    private $selectAnnee;
    private $selectMois;
    private $selectJour;

    public function __construct($db) {
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->connexion = $db->prepare("insert into connexions(emailco, dateco) values (:emailco, :dateco)");
        $this->select = $db->prepare("select idco, dateco, emailco from connexions order by dateco desc");
        $this->selectLimit = $db->prepare("select idco, dateco, emailco from connexions order by dateco desc limit :inf,:limite");
        $this->selectLimitEmail = $db->prepare("select emailco, dateco, idco from connexions where emailco= :emailco order by dateco desc limit :inf,:limite");
        $this->selectCount = $db->prepare("select count(*) as nb from connexions");
        $this->selectCountEmail = $db->prepare("select count(*) as nb from connexions where emailco=:emailco");
        $this->selectAnnee = $db->prepare("SELECT MONTH(dateco) as Mois, COUNT(*) as NombreDeCoParMois FROM connexions WHERE dateco BETWEEN :datedebutannee AND :datefinannee GROUP BY MONTH(dateco)");
        $this->selectMois = $db->prepare("SELECT DAY(dateco) as Jours, COUNT(*) as NombreDeCoParJours FROM connexions WHERE dateco BETWEEN :datedebutmois AND :datefinmois GROUP BY DAY(dateco)");
        $this->selectJour = $db->prepare("SELECT HOUR(dateco) as Heures, COUNT(*) as NombreDeCoParHeure FROM connexions WHERE dateco BETWEEN :datedebutjour AND :datefinjour GROUP BY HOUR(dateco)");
    }

    public function connexion($inputEmail, $dateco) {
        $r = true;
        $this->connexion->execute(array(':emailco' => $inputEmail, ':dateco' => $dateco));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->connexion->errorCode() != 0) {
            print_r($this->connexion->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function selectLimit($inf, $limite) {
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if ($this->selectLimit->errorCode() != 0) {
            print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }

    public function selectLimitEmail($inf, $limite, $emailco) {
        $this->selectLimitEmail->execute(array(':inf' => $inf, ':limite' => $limite, ':emailco' => $emailco));
        $this->selectLimitEmail->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimitEmail->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimitEmail->execute();
        if ($this->selectLimitEmail->errorCode() != 0) {
            print_r($this->selectLimitEmail->errorInfo());
        }
        return $this->selectLimitEmail->fetchAll();
    }

    public function selectCount() {
        $this->selectCount->execute();
        if ($this->selectCount->errorCode() != 0) {
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }

    public function selectCountEmail($emailco) {
        $this->selectCountEmail->execute(array(':emailco' => $emailco));
        if ($this->selectCountEmail->errorCode() != 0) {
            print_r($this->selectCountEmail->errorInfo());
        }
        return $this->selectCountEmail->fetch();
    }

    public function selectAnnee($datedebutannee, $datefinannee) {
        $this->selectAnnee->execute(array(':datedebutannee' => $datedebutannee, ':datefinannee' => $datefinannee));
        if ($this->selectAnnee->errorCode() != 0) {
            print_r($this->selectAnnee->errorInfo());
        }
        return $this->selectAnnee->fetchAll();
    }

    public function selectMois($datedebutmois, $datefinmois) {
        $this->selectMois->execute(array(':datedebutmois' => $datedebutmois, ':datefinmois' => $datefinmois));
        if ($this->selectMois->errorCode() != 0) {
            print_r($this->selectMois->errorInfo());
        }
        return $this->selectMois->fetchAll();
    }

    public function selectJour($datedebutjour, $datefinjour) {
        $this->selectJour->execute(array(':datedebutjour' => $datedebutjour, ':datefinjour' => $datefinjour));
        if ($this->selectJour->errorCode() != 0) {
            print_r($this->selectJour->errorInfo());
        }
        return $this->selectJour->fetchAll();
    }

}

?>