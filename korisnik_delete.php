<?php
    require_once("funkcije.php");
    $db = konekcija();
    if(!$db) exit();
    session_start();
    if(!loginProvera()){
        header("location:index.php");
    }
    if(!adminProvera()){
        echo "<div class='alert alert-danger'>Morate biti administrator kako biste pristupili ovoj stranici.</div>";
        exit();
    }
    if(!isset($_GET['id'])){
        echo "<div class='alert alert-danger'>Izvođač nije izabran.</div>";
        echo "<a href='izvodjac_show.php'>Izvođači</a>";
        exit();
    }
    $id=$_GET['id'];
    $upit = "DELETE FROM korisnik WHERE idKorisnika='{$id}'";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
        echo "<div class='alert alert-danger'>Izabrani korisnik ne postoji.</div>";
        echo "<a href='korisnik_show.php'>Korisnici</a>";
        exit();
    }
    else header("location:korisnik_show.php");
?>