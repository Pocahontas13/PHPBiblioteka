<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php

    session_start();

    if(!isset($_SESSION) || !$_SESSION['admin']) {
        header("Location: index.php");
    }

    if(isset($_GET['logout'])) {
        setcookie("PHPSESSID","",time()-1000,"/");
		session_destroy();
		header("Location: index.php");
    }

    require_once("Knjiga.php");
    require_once("Datebase.php");

    if(isset($_POST["unos"])) {
        $naziv = htmlspecialchars($_POST["naziv"]);
        $autor = htmlspecialchars($_POST['autor']);
        $cena = htmlspecialchars($_POST['cena']);
        $k = Knjiga::bezID($naziv, $autor, $cena);

        $db = new Datebase();
        $id = $db->unosKnjige($k);


        //upload slike
        if ($_FILES["slika"]["error"] == UPLOAD_ERR_OK ) {
            $ext = pathinfo(basename( $_FILES["slika"]["name"]), PATHINFO_EXTENSION);
            if (!move_uploaded_file($_FILES["slika"]["tmp_name"], "slike/" . $id . "." . $ext)) {
                $message = "Doslo je do problema sa uploadom slike.";
            }
        } else {
            switch( $_FILES["slika"]["error"] ) {
                case UPLOAD_ERR_INI_SIZE:
                    $m = "Slika je prevelika.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $m = "Slika je prevelika.";
                    break;
                default:
                    $m = "Doslo je do neocekivane greske.";
            }
            $message = "Slika ne moze da se uploaduje. $m";
        }

        //upload pdf-a
        if ($_FILES["pdf"]["error"] == UPLOAD_ERR_OK ) {
            $ext = pathinfo(basename( $_FILES["pdf"]["name"]), PATHINFO_EXTENSION);
            if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], "pdfovi/" . $id . "." . $ext)) {
                $message = "Doslo je do problema sa uploadom pdfa.";
            }
        } else {
            switch( $_FILES["pdf"]["error"] ) {
                case UPLOAD_ERR_INI_SIZE:
                    $m = "Pdf je prevelik.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $m = "Pdf je prevelik.";
                    break;
                default:
                    $m = "Doslo je do neocekivane greske.";
            }
            $message = "Pdf ne moze da se uploaduje. $m";
        }

        if(!empty($message)) {
            echo $message;
        }
    }

?>

<body>

    <a href="?logout"><button>Log out</button></a>

    <form method="POST" enctype="multipart/form-data">
        Naziv
        <br>
        <input type="text" name="naziv">
        <br>
        Autor
        <br>
        <input type="text" name="autor">
        <br>
        Cena
        <br>
        <input type="number" name="cena">
        <br>
        Slika
        <br>
        <input type="file" name="slika" accept=".jpg">
        <br>
        Pdf
        <br>
        <input type="file" name="pdf" accept=".pdf">
        <br>
        <input type="submit" name="unos" value="Sacuvaj">
    </form>
</body>
</html>