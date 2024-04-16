<?php
class Knjiga {
    private $id;
    private $naziv;
    private $autor;
    private $cena;


    public function __construct(){

    }

    public static function fromLine($line){
        $inst = new self();
        $inst->id = $line['id'];
        $inst->naziv = $line['naziv'];
        $inst->autor = $line['autor'];
        $inst->cena = $line['cena'];
        return $inst;
    }

    public static function bezID($naziv, $autor, $cena) {
        $inst = new self();
        $inst->naziv = $naziv;
        $inst->autor = $autor;
        $inst->cena = $cena;
        return $inst;
    }

    public function get_html() {
        $html = "
        <a href=\"?id=$this->id\"><div class=\"flex-child\">
            <img src='slike/$this->id.jpg' width='200'><br>
            <h3>$this->naziv</h3>
            <h3>$this->cena din</h3>
        </div></a>        
        ";
        return $html;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getNaziv() {
        return $this->naziv;
    }

    public function getCena() {
        return $this->cena;
    }

    public function getId() {
        return $this->id;
    }
}
?>