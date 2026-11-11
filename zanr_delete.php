<?php
    require_once("funkcije.php");
    $db = konekcija();
    if(!$db) exit();
    session_start();
    if(!loginProvera()){
        header("location:index.php");
    }
    require_once("header.php");
    if(!adminProvera()){
        echo "<div class='alert alert-danger'>Morate biti administrator kako biste pristupili ovoj stranici.</div>";
        exit();
    }
    if(!isset($_GET['id'])){
        echo "<div class='alert alert-danger'>Žanr nije izabran.</div>";
        echo "<a href='zanr_show.php'>Žanrovi</a>";
        exit();
    }
    $id=$_GET['id'];
    $upit="SELECT obrisan FROM zanr where idZanra='{$id}'";
    $red = mysqli_fetch_assoc(mysqli_query($db,$upit));
    $obrisan=($red['obrisan']) ? '0' : '1';
    $upit = "UPDATE zanr SET obrisan='{$obrisan}' WHERE idZanra='{$id}'";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
        echo "<div class='alert alert-danger'>Izabrani žanr ne postoji.</div>";
        echo "<a href='zanr_show.php'>Žanrovi</a>";
        exit();
    }
    else header("location:zanr_show.php");

?>