<?php
    require_once("funkcije.php");
    $db=konekcija();
    if(!$db)exit();
    session_start();
    if(!loginProvera()){
        header("location:index.php");
    }
    require_once("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Narudžbine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Narudžbine</h1>
    <hr>
    <div class="container">
        <?php
            $upit="SELECT kupovina.idKupovine,kupovina.vreme,korisnik.idKorisnika,korisnik.ime,korisnik.prezime,korisnik.adresa,korisnik.email FROM kupovina INNER JOIN korisnik ON kupovina.idKorisnika=korisnik.idKorisnika";
            if($_SESSION['status']=="korisnik")
            $upit.=" WHERE korisnik.idKorisnika='{$_SESSION['id']}'";
            else if(isset($_GET['id'])){
                $upit.=" WHERE korisnik.idKorisnika='{$_GET['id']}'";
            }
            $upit.=" ORDER BY vreme DESC";
            $rez=mysqli_query($db,$upit);
            if(!$rez or mysqli_num_rows($rez)==0){
                if(isset($_GET['id'])) echo "<div class='alert alert-info'>Korisnik nema narudžbine.</div>";
                else echo "<div class='alert alert-info'>Ne postoji nijedna narudžbina.</div>";
                exit();
            }
            while($red=mysqli_fetch_assoc($rez)){
                echo "<div class='row border border-success mb-2 py-3'>";
                    echo "<div class='col-10'>";
                    echo "<h4>";
                    if($_SESSION['status']=='administrator')
                    echo "{$red['idKupovine']}: ";
                    $vreme=date_format(date_create($red['vreme']),"d.m.Y H:i:s");
                    echo "{$vreme}</h4></div>";
                    echo "<div class='col col-10'>";
                    if($_SESSION['status']=='administrator'){
                        echo "ID korisnika: {$red['idKorisnika']}: {$red['ime']} {$red['prezime']}, {$red['adresa']} ({$red['email']})<br>";
                    }
                    echo "Proizvodi:<br><ul>";
                    $upit="SELECT * FROM specifikacija WHERE idKupovine='{$red['idKupovine']}'";
                    $rez1=mysqli_query($db,$upit);
                    $iznos=0;
                    while($red1=mysqli_fetch_assoc($rez1)){
                        $upit="SELECT idIzdanja,naziv,cena FROM izdanje WHERE idIzdanja='{$red1['idIzdanja']}'";
                        $rez2=mysqli_query($db,$upit);
                        $red2=mysqli_fetch_assoc($rez2);
                        $upit="SELECT idIzvodjaca FROM izdanjeIzvodjac where idIzdanja='{$red2['idIzdanja']}'";
                        $rez3=mysqli_query($db,$upit);
                        $poruka="";
                        while($red3=mysqli_fetch_assoc($rez3)){
                            $upit="SELECT ime from izvodjac where idIzvodjaca='{$red3['idIzvodjaca']}'";
                            $red4=mysqli_fetch_assoc(mysqli_query($db,$upit));
                            $poruka.=$red4['ime'].", ";
                        }
                        $poruka=rtrim($poruka,", ");
                        $poruka.=" — ";
                        echo "<li>{$poruka}{$red2['naziv']} ({$red1['kolicina']})</li>";
                        $iznos+=$red2['cena']*$red1['kolicina'];
                    }
                    echo "</div></ul><h3>Iznos: {$iznos}</h3>";
                    echo "</div>";
            }
        ?>
    </div>
</body>
</html>