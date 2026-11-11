<?php
    require_once("funkcije.php");
    $db = konekcija();
    if(!$db) exit();
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
    <title>Izvođači</title>
</head>
<body>
        <h1>Izvođači</h1>
        <hr>
        
    <div class="container">

        <?php
            $upit="SELECT * FROM izvodjac";
            $rez=mysqli_query($db, $upit);
            echo "Broj izvođača: <b>".mysqli_num_rows($rez)."</b><br>";
            if($_SESSION['status']=='administrator')
            echo "<a href='izvodjac_create.php'>Dodaj izvođača</a>";
            echo "<hr>";
            while($red=mysqli_fetch_assoc($rez)){
                    if(!$red['obrisan'] || $_SESSION['status']=='administrator'){
                    echo "<div class='row border border-success mb-2 py-3'>";
                    echo "<div class='col-10'>";
                    echo "<h4>";
                    if($_SESSION['status']=='administrator')
                    echo "{$red['idIzvodjaca']}: ";
                    echo "{$red['ime']}</h4></div>";
                    if($_SESSION['status']=='administrator'){
                        echo "<div class='col-1'><a class='btn btn-success m-1' href='izvodjac_update.php?id={$red['idIzvodjaca']}'>Izmena</a></div>";
                        if(!$red['obrisan'])
                        echo "<div class='col-1'><a class='btn btn-danger m-1' href='izvodjac_delete.php?id={$red['idIzvodjaca']}'>Brisanje</a></div>";
                        else echo "<div class='col-1'><a class='btn btn-warning m-1' href='izvodjac_delete.php?id={$red['idIzvodjaca']}'>Vrati</a></div>";
                    }
                    echo "<div class='col-10'><a class='btn btn-light m-1' href='izdanje_show.php?id={$red['idIzvodjaca']}'><h6>Prikaži izdanja izvođača</h6></a></div>";
                    echo "</div>";
                }
            }
            
            mysqli_close($db);
        ?>
    </div>
</body>
</html>