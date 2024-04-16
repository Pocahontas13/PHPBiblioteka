<?php

session_start();

require_once("Datebase.php");
require_once("Korisnik.php");


$db = new Datebase();

if (isset($_POST["sub"])){
    if (empty($_POST["user"]) || empty($_POST["password"])){
        echo "Proverite da li ste uneli sva polja";
    }else {
        $userName = htmlspecialchars($_POST["user"]);
        $password = htmlspecialchars($_POST["password"]);
        //echo $userName." ".$password;
        $korisnik = $db->login($userName, $password);
        if(!$korisnik){
            echo "Korisnik nije pronadjen, pokusajte ponovo ili se registrujte.";
        } else {
            $_SESSION["korisnik"] = serialize($korisnik);
            setcookie('korisnik', $korisnik->getUsername(), time()+365*24*60*60);
            header("Location: glavna.php");
        }
    }
}

if (isset($_POST["sub2"])){
    header("Location:registracija.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Svet knjiga</title>
</head>
<body>
    <h1>Svet knjiga</h1>
    <br>
    <form method="POST">
        Korisnik
        <input type="text" name = "user" <?php
         if(isset($_COOKIE['korisnik'])){
            echo "value = \"{$_COOKIE['korisnik']}\"";
        } else {
            echo "value=\"\"";
        }?>>
        Sifra
        <input type="password" name = "password">
        <input type="submit" name = "sub" value="Uloguj se">
    </form>
    <br>
    <form method="POST">
        Ako zelite da se registrujete:<input type="submit" name = "sub2" value="Registracija">
    </form>
    <br>
    <a href="admin.php"><button>Uloguj se kao admin</button></a>
</body>
</html>