<?php
class Korisnik{
    private $id;
    private $ime;
    private $prezime;
    private $username;
    private $email;

    public function __construct($line){
        $this->id = $line["id"];
        $this->username = $line['username'];
        $this->ime = $line['ime'];
        $this->prezime = $line['prezime'];
        $this->email = $line['email'];
    }

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getIme(){
        return $this->ime;
    }

    public function getPrezime(){
        return $this->prezime;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }
}
?>