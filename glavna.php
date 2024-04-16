<?php

    session_start();

    require_once("Korisnik.php");
    require_once("Datebase.php");
    require_once("Knjiga.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Svet knjiga</title>
</head>
<body>
    <h1>Dobrodosli na stranicu biblioteke "Svet knjiga"</h1>

<?php 

    if(isset($_GET['logout'])) {
        setcookie("PHPSESSID","",time()-1000,"/");
		session_destroy();
		header("Location: index.php");
    }

    if(isset($_GET['forget'])) {
        setcookie("PHPSESSID","",time()-1000,"/");
        setcookie("korisnik","",time()-1000);
		session_destroy();
		header("Location: index.php");
    }


    $korisnik = unserialize($_SESSION["korisnik"]);
    echo "<h3>Dobrodosli " . $korisnik->getIme() . "</h3><br>";
    echo "<a href=?logout><button>Log out</button></a>";
    echo "<a href=?forget><button>Zaboravi me</button></a>";

    if(isset($_GET["id"])) {
        $id=htmlspecialchars($_GET["id"]);
        $putanja = "pdfovi/$id.pdf";

        if(!file_exists($putanja)){ 
            die('file not found');
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$id.pdf");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
        
            // read the file from disk
            readfile($putanja);
            echo "Uspesno ste kupili knjigu!<br>";
        }

    }

    $db = new Datebase();
    $knjige = $db->getKnjige();

    echo "<div class=\"flex-container\">";
    foreach($knjige as $k) {
        echo $k->get_html();
    }
    echo "</div>";
?>


</body>
</html>