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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .container{
            width:60%;
        }
        .polje{
            padding:5;
        }
        .zanr{
            color:grey;
            font-size:13px;
        }
    </style>
    <title>Izdanja</title>
</head>
<body>
        <h1>Izdanja</h1>
        <hr>
    <div class="container">
        

        <?php
            $upit="SELECT * FROM izdanje";
            if(isset($_GET['z']) and isset($_GET['id'])){
                echo "<a class='btn btn-light m-1' href='izdanje_show.php'><h5>Nazad na sva izdanja</h5></a>";
                echo "<a class='btn btn-light m-1' href='zanr_show.php'><h5>Nazad na sve žanrove</h5></a>";
                exit();
            }
            if(isset($_GET['id'])){
                $id=$_GET['id'];
                $upit1="SELECT ime, IFNULL(bio,'') as 'bio' FROM izvodjac where idIzvodjaca='{$id}'";
                $rez=mysqli_query($db, $upit1);
                if(!$red=mysqli_fetch_assoc($rez)){
                    echo "<div class='alert alert-info'>Izvođač ne postoji.</div>";
                    echo "<a class='btn btn-light m-1' href='izdanje_show.php'><h5>Nazad na sva izdanja</h5></a>";
                    echo "<a class='btn btn-light m-1' href='izvodjac_show.php'><h5>Nazad na sve izvođače</h5></a>";
                    exit();
                }
                echo "<h3>{$red['ime']}</h3><hr>";
                if($red['bio']) echo "{$red['bio']}<br><br>";
                $upit.=" where idIzdanja in(select idIzdanja from izdanjeIzvodjac where idIzvodjaca='{$id}')";
            }
            $rez=mysqli_query($db, $upit);
            if(!$rez){
                if(isset($_GET['id'])) echo "<div class='alert alert-info'>Izabrani izvođač trenutno nema izdanja na prodaju.</div>";
                else echo "<div class='alert alert-info'>Trenutno nema izdanja na prodaju.</div>";
                echo "<a class='btn btn-light m-1' href='izdanje_show.php'><h5>Nazad na sva izdanja</h5></a>";
                echo "<a class='btn btn-light m-1' href='izvodjac_show.php'><h5>Nazad na sve izvođače</h5></a>";
                exit();
            }
            if(isset($_GET['z'])){
                $z=$_GET['z'];
                $upit1="SELECT nazivZanra FROM zanr where idZanra='{$z}'";
                $rez=mysqli_query($db, $upit1);
                if(!$red=mysqli_fetch_assoc($rez)){
                    echo "<div class='alert alert-info'>Žanr ne postoji.</div>";
                    echo "<a class='btn btn-light m-1' href='izdanje_show.php'><h5>Nazad na sva izdanja</h5></a>";
                    echo "<a class='btn btn-light m-1' href='zanr_show.php'><h5>Nazad na sve žanrove</h5></a>";
                    exit();
                }
                echo "<h3>{$red['nazivZanra']}</h3><hr><br><br>";
                $upit.=" where idIzdanja in(select idIzdanja from izdanjeZanr where idZanra='{$z}')";
            }
            $rez=mysqli_query($db, $upit);
            if(!$rez or mysqli_num_rows($rez)==0){
                if(isset($_GET['id'])) echo "<div class='alert alert-info'>Izabrani izvođač trenutno nema izdanja na prodaju.</div>";
                else if(isset($_GET['z'])) echo "<div class='alert alert-info'>Izabrani žanr trenutno nema izdanja na prodaju.</div>";
                else echo "<div class='alert alert-info'>Trenutno nema izdanja na prodaju.</div>";
                exit();
            }
            echo "Broj izdanja: <b>".mysqli_num_rows($rez)."</b><br>";
            if($_SESSION['status']=='administrator')
            echo "<a href='izdanje_create.php'>Dodaj izdanje</a>";
            echo "<hr>";
            while($red=mysqli_fetch_assoc($rez)){
                if(($red['obrisan']=='0' and $red['naStanju']=='1') || $_SESSION['status']=="administrator"){
                $upit="SELECT idIzvodjaca,ime FROM izvodjac WHERE idIzvodjaca in(SELECT idIzvodjaca FROM izdanjeIzvodjac where idIzdanja='{$red['idIzdanja']}')";
                $rez1=mysqli_query($db,$upit);
                $poruka="";
                while($red1=mysqli_fetch_assoc($rez1)){
                    $poruka.=$red1['ime'].", ";
                }
                $poruka=rtrim($poruka,", ");
                $poruka.=" — ";
                echo "<div class='row border border-success mb-3 polje'>";
                echo "<div class='col align-self-center'>";
                $format = strtoupper($red['format']);
                $tip = strtoupper($red['tip']);
                echo "<div class='col-10 my-2'><img src='uploads/{$red['slika']}' width='200px' height='200px'><br><br>";
                echo "<h3>{$poruka} {$red['naziv']} ({$red['godina']})</h3>{$format} {$tip}";
                $upit="SELECT idZanra FROM izdanjeZanr where idIzdanja='{$red['idIzdanja']}'";
                $rez1=mysqli_query($db,$upit);
                $poruka="";
                while($red1=mysqli_fetch_assoc($rez1)){
                    $upit="SELECT nazivZanra from zanr where idZanra='{$red1['idZanra']}'";
                    $red2=mysqli_fetch_assoc(mysqli_query($db,$upit));
                    $poruka.=strtoupper($red2['nazivZanra'])." / ";
                }
                $poruka=rtrim($poruka," / ");
                echo "<br><p class='zanr'>{$poruka}</p>";
                echo "</div></div>";
                echo "<div class='col-10 py-3'><h5>Cena: {$red['cena']}</h5></div>";
                if($_SESSION['status']=='korisnik')
                echo "<div class='col-9 pb-3'><a class='btn btn-success m-1' href='korpa_update.php?id={$red['idIzdanja']}&operacija=dodaj&adresa=izdanje_show'><h5>Dodaj u korpu</h5></a></div>";
                if($_SESSION['status']=='administrator'){
                    echo "<div class='col-10 py-3'><h6>Zalihe: {$red['kolicina']} (";
                    if($red['naStanju']) echo "na stanju)";
                    else echo "nije na stanju)";
                    echo "</h5></div>";
                    echo "<div class='col-10'>";
                    echo "<div class='col-1'><a class='btn btn-primary m-1' href='izdanje_update.php?id={$red['idIzdanja']}'>Izmena</a></div>";
                    echo "<div class='col-1'><a class='btn btn-";
                    if($red['obrisan']==0) echo "danger m-1' href='izdanje_delete.php?id={$red['idIzdanja']}'>Brisanje</a></div></div>";
                    else echo "warning m-1' href='izdanje_delete.php?id={$red['idIzdanja']}'>Vrati</a></div></div>";
                }

                echo "</div>";
            }
        }
            mysqli_close($db);
        ?>
    </div>
</body>
</html>