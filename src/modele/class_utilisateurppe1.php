<?php

class Utilisateurppe1 {

    private $db;    // déclaration de la variable en privé (uniquement pour la classe) // $db c'est la variable de connection
    private $insert;
    private $connect;
    private $select;
    private $delete;
    private $selectByEmail;
    private $update;
    private $updatesansphoto;
    private $updateuniquementphoto;
    private $updateconnect;
    private $updaterecup;
    private $updatemdp;
    private $connexion;
    private $updatevalide;
    private $updatevalidecompte;
    private $selectbyemailcoder;

//    private $selectByEmailPhoto;



    public function __construct($db) {
        $this->db = $db;    //je parle à db dans le private et je lui donne la valeur qui est dans le __construct
        $this->insert = $db->prepare("insert into utilisateurppe1(email, mdp, idRole, nom, prenom, photo, dateinscription, datedernier, numunique, adrr) values (:email, :mdp, :role, :nom, :prenom, :photo, :dateinscription, :datedernier, :numunique, :adrr)");
        $this->connect = $db->prepare("select email, idRole, mdp from utilisateurppe1 where email=:email");
        $this->select = $db->prepare("select email, adrr, id, idRole, photo, nom, prenom, dateinscription, datedernier, numunique r.libelle as libellerole from utilisateurppe1 u, roleppe1 r where u.idRole = r.id order by nom");
        $this->delete = $db->prepare("delete from utilisateurppe1 where utilisateurppe1.email=:email"); //requette ok
        $this->selectByEmail = $db->prepare("select email, adrr, nom, prenom, idRole, dateinscription, photo, numrecup, numunique, valide from utilisateurppe1 where email=:email");
        $this->update = $db->prepare("update utilisateurppe1 set nom=:nom, prenom=:prenom, mdp=:mdp, idRole=:role, photo=:photo where email=:email");
        $this->updatesansphoto = $db->prepare("update utilisateurppe1 set nom=:nom, prenom=:prenom, mdp=:mdp, idRole=:role where email=:email");
        $this->updateuniquementphoto = $db->prepare("update utilisateurppe1 set photo=:photo where email=:email");
        $this->updateconnect = $db->prepare("update utilisateurppe1 set datedernier=:datedernier where email=:email");
        $this->updaterecup = $db->prepare("update utilisateurppe1 set daterecup=:daterecup, numrecup=:numrecup where email=:email");
        $this->updatemdp = $db->prepare("update utilisateurppe1 set mdp=:mdp where email=:email");
        $this->connexion = $db->prepare("insert into connexions(emailco, dateco, deco) values (:emailco, :dateco, :deco)");
        $this->updatevalide = $db->prepare("update utilisateurppe1 set numunique=:numunique where email=:email");
        $this->updatevalidecompte = $db->prepare("update utilisateurppe1 set datevalide=:datevalide, valide=:valide where email=:email");
        $this->selectbyemailcoder = $db->prepare("Select id, watt, nom, emailcoder, hpj, jpa from language l, coder c where c.idLanguage = l.id and emailcoder=:emailcoder");
    }

    public function insert($email, $mdp, $role, $nom, $prenom, $photo, $dateinscription, $datedernier, $numunique, $adrr) {
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':photo' => $photo, ':dateinscription' => $dateinscription, ':datedernier' => $datedernier, ':numunique' => $numunique, ':adrr' => $adrr));  //on exécute les requètes préparés dans le prepare et on affecte les valeurs SQL aux valeurs du formulaire. ATTENTION à l'ordre et à la position !!
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function connect($email) {
        $unUtilisateur = $this->connect->execute(array(':email' => $email));
        if ($this->connect->errorCode() != 0) {
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    public function select() {
        $liste = $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function delete($email) {
        $r = true;
        $this->delete->execute(array(':email' => $email));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectByEmail($email) {
        $this->selectByEmail->execute(array(':email' => $email));
        if ($this->selectByEmail->errorCode() != 0) {
            print_r($this->selectByEmail->errorInfo());
        }
        return $this->selectByEmail->fetch();
    }

    public function update($email, $role, $nom, $prenom, $mdp, $photo) {
        $r = true;
        $this->update->execute(array(':email' => $email, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':mdp' => $mdp, ':photo' => $photo));
        if ($this->update->errorCode() != 0) {
            print_r($this->update->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updatesansphoto($email, $role, $nom, $prenom, $mdp) {
        $r = true;
        $this->updatesansphoto->execute(array(':email' => $email, ':role' => $role, ':nom' => $nom, ':prenom' => $prenom, ':mdp' => $mdp));
        if ($this->updatesansphoto->errorCode() != 0) {
            print_r($this->updatesansphoto->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateuniquementphoto($email, $photo) {
        $r = true;
        $this->updateuniquementphoto->execute(array(':email' => $email, ':photo' => $photo));
        if ($this->updateuniquementphoto->errorCode() != 0) {
            print_r($this->updateuniquementphoto->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updateconnect($email, $datedernier) {
        $r = true;
        $this->updateconnect->execute(array(':email' => $email, ':datedernier' => $datedernier));
        if ($this->updateconnect->errorCode() != 0) {
            print_r($this->updateconnect->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updaterecup($daterecup, $numrecup, $email) {
        $r = true;
        $this->updaterecup->execute(array(':daterecup' => $daterecup, ':numrecup' => $numrecup, ':email' => $email));
        if ($this->updaterecup->errorCode() != 0) {
            print_r($this->updaterecup->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updatemdp($email, $mdp) {
        $r = true;
        $this->updatemdp->execute(array(':email' => $email, ':mdp' => $mdp));
        if ($this->updatemdp->errorCode() != 0) {
            print_r($this->updatemdp->errorInfo());
            $r = false;
        }
        return $r;
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

    public function updatevalide($numunique, $email) {
        $r = true;
        $this->updatevalide->execute(array(':numunique' => $numunique, ':email' => $email));
        if ($this->updatevalide->errorCode() != 0) {
            print_r($this->updatevalide->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function updatevalidecompte($datevalide, $email, $valide) {
        $r = true;
        $this->updatevalidecompte->execute(array(':datevalide' => $datevalide, ':email' => $email, ':valide' => $valide));
        if ($this->updatevalidecompte->errorCode() != 0) {
            print_r($this->updatevalidecompte->errorInfo());
            $r = false;
        }
        return $r;
    }

    public function selectbyemailcoder($emailcoder) {
        $this->selectbyemailcoder->execute(array(':emailcoder' => $emailcoder));
        if ($this->selectbyemailcoder->errorCode() != 0) {
            print_r($this->selectbyemailcoder->errorInfo());
        }
        return $this->selectbyemailcoder->fetchAll();
    }

}

?>