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
        echo "<div class='alert alert-danger'>Izdanje nije izabrano.</div>";
        echo "<a href='izdanje_show.php'>Izdanja</a>";
        exit();
    }
    $id=$_GET['id'];
    $upit="SELECT obrisan FROM izdanje where idIzdanja='{$id}'";
    $red = mysqli_fetch_assoc(mysqli_query($db,$upit));
    $obrisan=($red['obrisan']) ? '0' : '1';
    $upit = "UPDATE izdanje SET obrisan='{$obrisan}' WHERE idIzdanja='{$id}'";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
        echo "<div class='alert alert-danger'>Izabrano izdanje ne postoji.</div>";
        echo "<a href='izdanje_show.php'>Izdanja</a>";
        exit();
    }
    else header("location:izdanje_show.php");
?>