<?php
    require_once("funkcije.php");
    $db = konekcija();
    if(!$db) exit();
    session_start();
    if(!loginProvera()){
        header("location:index.php");
    }
    require_once("header.php");
    if(!korisnikProvera()){
        echo "<div class='alert alert-danger'>Morate biti korisnik kako biste pristupili ovoj stranici.</div>";
        exit();
    }
    if(!isset($_GET['adresa'])){
        exit();
    }
    if(!isset($_GET['id'])){
        echo "<div class='alert alert-danger'>Izdanje nije izabrano.</div>";
        echo "<a href='izdanje_show.php'>Izdanja</a>";
        exit();
    }
    if(!isset($_GET['operacija']) or ($_GET['operacija']!='dodaj' and $_GET['operacija']!='brisi')){
        echo "<div class='alert alert-danger'>Neispravna operacija.</div>";
        echo "<a href='izdanje_show.php'>Izdanja</a>";
        exit();
    }
    extract($_GET);
    $upit = "SELECT idIzdanja,kolicina FROM izdanje WHERE idIzdanja='{$id}'";
    $rez = mysqli_query($db,$upit);
    if(!$rez){
        echo "<div class='alert alert-danger'>Izabrano izdanje ne postoji.</div>";
        echo "<a href='izdanje_show.php'>Izdanja</a>";
        exit();
    }
    $red=mysqli_fetch_assoc($rez);
    $korpa=$_SESSION['korpa'];
    if($operacija=='dodaj'){
        if(intval($korpa[1])==$red['kolicina'])
        exit();
        $dodat=0;
        foreach($korpa as &$izdanje){
            if($izdanje[0]==$id){
                $kolicina=intval($izdanje[1]);
                echo "Prva Kolicina: {$kolicina}<br>";
                $kolicina++;
                echo "Druga Kolicina: {$kolicina}<br>";
                $izdanje[1]="{$kolicina}";
                echo "String Kolicina: {$izdanje[1]}<br>";
                $dodat=1;
                break;
            }
        }
        if(!$dodat){
            $proizvod=array($id,"1");
            array_push($korpa,$proizvod);
        }
    }
    else{
        $obrisan=0;
        $indeks=0;
        foreach($korpa as &$izdanje){
            if($izdanje[0]==$id){
                $kolicina=intval($izdanje[1]);
                $kolicina--;
                $izdanje[1]="{$kolicina}";
                $obrisan=1;
                if($kolicina<=0){
                    unset($korpa[$indeks]);
                    $korpa = array_values($korpa);
                }
                break;
            }
            $indeks++;
        }
    }
    $_SESSION['korpa']=$korpa;
    header("location:{$adresa}.php");
?>