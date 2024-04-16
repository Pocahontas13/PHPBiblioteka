<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php

session_start();

if (isset($_POST["sub"])){
    if (empty($_POST["user"]) || empty($_POST["password"])){
        echo "Proverite da li ste uneli sva polja";
    }else {
        $userName = htmlspecialchars($_POST["user"]);
        $password = htmlspecialchars($_POST["password"]);
        //echo $userName." ".$password;
        //ako prolazi provera da li je dobar username i pass
        if($userName == "admin" && $password == "admin"){
            $_SESSION['admin'] = true;
            header("Location: admin_unos.php");
        } else {
            header("Location: index.php");
        }
    }
}
?>

<body>
    <form method="POST">
        Admin
        <input type="text" name = "user">
        Sifra
        <input type="password" name = "password">
        <input type="submit" name = "sub" value="Uloguj se">
    </form>
</body>
</html>