<?php
class Datebase
{
    private $conn;

    public function __construct($configFile = "config.ini")
    {
        if ($config = parse_ini_file($configFile)) {
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    public function unosKnjige($knjiga){
        $upit = "INSERT INTO Knjiga (autor, cena, naziv) values (:autor, :cena, :naziv)";
        $statement = $this->conn->prepare($upit);
        $statement->bindValue(":autor", $knjiga->getAutor());
        $statement->bindValue(":cena", $knjiga->getCena());
        $statement->bindValue(":naziv", $knjiga->getNaziv());
        $ok = $statement->execute();
        if($ok) {
            return $this->conn->lastInsertId();
        } else {
            return "nije ok";
        }
    }

    public function login($user, $pass) {
        $sql = "SELECT * FROM korisnik WHERE username=:user AND password=:pass";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":user", $user);
        $stmt->bindValue(":pass", $pass);
        $stmt->execute();
        $kor = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($kor)) {
            $k = new Korisnik($kor);
            return $k;
        } else {
            return false;
        }
    }

    public function registracija($korisnik, $pass) {
        $sql = "INSERT INTO korisnik (username, password, ime, prezime, email) VALUES (:user, :pass, :ime, :prezime, :email)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":user", $korisnik->getUsername());
        $stmt->bindValue(":pass", $pass);
        $stmt->bindValue(":ime", $korisnik->getIme());
        $stmt->bindValue(":prezime", $korisnik->getPrezime());
        $stmt->bindValue(":email", $korisnik->getEmail());
        $ok = $stmt->execute();
        if($ok) {
            $id = $this->conn->lastInsertId();
            $korisnik->setId($id);
            return $korisnik;
        } else {
            return "Korisnik nije dodat";
        }
        
    }


    public function getKnjige() {
        $sql = "SELECT * FROM knjiga";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rez = $stmt->fetchAll();

        $knjige = array();
        foreach($rez as $line) {
            $k = Knjiga::fromLine($line);
            $knjige[] = $k;
        }

        return $knjige;
    }
}


?>