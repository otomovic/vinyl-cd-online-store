<?php
    require_once("funkcije.php");
    $db = konekcija();
    if(!$db) exit();
    session_start();
    if(!loginProvera()){
        header("location:index.php");
    }
    if(!korisnikProvera()){
        echo "<div class='alert alert-danger'>Morate biti korisnik kako biste pristupili ovoj stranici.</div>";
        exit();
    }
    require_once("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Korpa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Korpa</h1>
    <hr>
    <div class="container">
        <?php
            $n = sizeof($_SESSION['korpa']);
            $iznos=0;
            echo "Broj proizvoda u korpi: <b>{$n}</b>";
            echo "<br><br>";
            foreach($_SESSION['korpa'] as $proizvod){
                $upit="SELECT * FROM izdanje where idIzdanja='{$proizvod[0]}'";
                $rez=mysqli_query($db,$upit);
                $red=mysqli_fetch_assoc($rez);
                $kolicina=intval($proizvod[1]);
                $iznos+=$red['cena']*$kolicina;
                $upit="SELECT idIzvodjaca FROM izdanjeIzvodjac where idIzdanja='{$red['idIzdanja']}'";
                $rez=mysqli_query($db,$upit);
                $poruka="";
                while($red1=mysqli_fetch_assoc($rez)){
                    $upit="SELECT ime from izvodjac where idIzvodjaca='{$red1['idIzvodjaca']}'";
                    $red2=mysqli_fetch_assoc(mysqli_query($db,$upit));
                    $poruka.=$red2['ime'].", ";
                }
                $poruka=rtrim($poruka,", ");
                $poruka.=" — ";
                echo "<div class='row border border-success mb-2'>";
                echo "<div class='col-10'>";
                echo "<h4>{$poruka} {$red['naziv']}</h4></div>";
                echo "<br><div class='col-10 align-self-center'><a class='btn btn-success m-1' href='korpa_update.php?id={$red['idIzdanja']}&operacija=brisi&adresa=korpa'>-</a>";
                echo "     {$proizvod[1]}     ";
                echo "<a class='btn btn-success m-1' href='korpa_update.php?id={$red['idIzdanja']}&operacija=dodaj&adresa=korpa'>+</a></div>";
                echo "<div class='col-1 my-2'><img src='uploads/{$red['slika']}' width='200px' height='200px'><br><br></div>";

                echo "</div>";
            }
            echo "<h3>Iznos: {$iznos} RSD</h3><br>";
            if($iznos>0){
                echo "<button class='btn btn-success' onclick='kupi()'><h3>Kupi</h3></button>";
            }
            echo "<hr>";
        ?>
        <div id="odgovor"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
            $(function(){

            })
            
            function kupi(){
                let odgovor = $("#odgovor");
                $.post("kupovina.php", {moze:1}, function(response){
                    odgovor.html(response);
                })
            }
    </script>
</body>
</html>