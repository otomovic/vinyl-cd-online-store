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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Korisnici</title>
</head>
<body>
        <h1>Korisnici</h1>
        <hr>
    <div class="container">
        

        <?php
            $upit="SELECT * FROM korisnik";
            $rez=mysqli_query($db, $upit);
            echo "Broj korisnika: <b>".mysqli_num_rows($rez)."</b><br>";
            echo "<a href='korisnik_create.php'>Dodaj korisnika</a><hr>";
            while($red=mysqli_fetch_assoc($rez)){
                echo "<div class='row border border-success mb-2'>";
                echo "<div class='col-10'>";
                echo "{$red['idKorisnika']}: {$red['ime']} {$red['prezime']} ({$red['email']}), {$red['adresa']}, status: {$red['status']}</div>";
                echo "<div class='col-1'><a class='btn btn-success m-1' href='korisnik_update.php?id={$red['idKorisnika']}'>Izmena</a></div>";
                echo "<div class='col-1'><a class='btn btn-danger m-1' href='korisnik_delete.php?id={$red['idKorisnika']}'>Brisanje</a></div>";
                if($red['status']=='korisnik')
                    echo "<div class='col-10'><a class='btn btn-light m-1' href='kupovina_show.php?id={$red['idKorisnika']}'><h5>Prikaži kupovine ovog korisnika</h5></a></div>";

                echo "</div>";
            }
            
            mysqli_close($db);
        ?>
    </div>
</body>
</html>