<?php

session_start();

require_once("Korisnik.php");
require_once("Datebase.php");

if (isset($_POST["sub3"])){
    if ( empty($_POST["ime"]) || empty($_POST["prezime"]) || empty($_POST["email"]) || empty($_POST["kIme"]) || empty($_POST["sifra1"]) || empty($_POST["sifra2"])){
        echo "Unesite sve podatke!";
    }else if (!empty($_POST["sifra1"]) && !empty($_POST["sifra2"]) && ($_POST["sifra1"]) != ($_POST["sifra2"])){
        echo "Sifre se ne slazu, unesite ponovo!";
    }else{
        $k_asoc = array();
        $k_asoc["ime"] = htmlspecialchars($_POST["ime"]);
        $k_asoc["prezime"] = htmlspecialchars($_POST["prezime"]);
        $k_asoc["email"] = htmlspecialchars($_POST["email"]);
        $k_asoc["username"] = htmlspecialchars($_POST["kIme"]);
        $k_asoc["id"] = "";
        $pass = htmlspecialchars($_POST["sifra1"]);
        $s2 = htmlspecialchars($_POST["sifra2"]);

        echo "napravio asoc niz<br>";

        $k = new Korisnik($k_asoc);
        echo "naravio korisnika <br>";
        $db = new Datebase();
        $k = $db->registracija($k, $pass);
        echo "db reg prosla<br>";
        if($k === "Korisnik nije dodat") {
            echo "Doslo je do greske, pokusajte ponovo";
        } else {
            $_SESSION["korisnik"] = serialize($k);
            setcookie('korisnik', $k->getUsername(), time()+365*24*60*60);
            header("Location: glavna.php");
        }

    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
</head>
<body>
    <h1>Registracija</h1>
    <form method="POST">
        Ime:<input type="text" name="ime">
        <br>
        <br>
        Prezime:<input type="text" name="prezime">
        <br>
        <br>
        e-mail:<input type="email" name="email">
        <br>
        <br>
        Korisnicko ime:<input type="text" name="kIme">
        <br>
        <br>
        Unesite sifru:<input type="text" name="sifra1">
        <br>
        <br>
        Ponovi sifru:<input type="text" name="sifra2">
        <br>
        <br>
        <input type="submit" name="sub3" text="Sacuvaj">
    </form>
</body>
</html>