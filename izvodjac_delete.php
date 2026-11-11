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
    $upit="SELECT obrisan FROM izvodjac where idIzvodjaca='{$id}'";
    $red = mysqli_fetch_assoc(mysqli_query($db,$upit));
    $obrisan=($red['obrisan']) ? '0' : '1';
    $upit = "UPDATE izvodjac SET obrisan='{$obrisan}' WHERE idIzvodjaca='{$id}'";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
        echo "<div class='alert alert-danger'>Izabrani izvođač ne postoji.</div>";
        echo "<a href='izvodjac_show.php'>Izvođači</a>";
        exit();
    }
    else header("location:izvodjac_show.php");
?>