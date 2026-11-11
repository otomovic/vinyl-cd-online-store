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
    <title>Žanrovi</title>
</head>
<body>
        <h1>Žanrovi</h1>
        <hr>
    <div class="container">
        

        <?php
            $upit="SELECT * FROM zanr";
            if($_SESSION['status']!='administrator'){
                $upit.=" WHERE obrisan='0'";
            }
            $rez=mysqli_query($db, $upit);
            echo "Broj žanrova: <b>".mysqli_num_rows($rez)."</b><br>";
            if($_SESSION['status']=='administrator'){
                echo "<a href='zanr_create.php'>Dodaj žanr</a><hr>";
            }
            while($red=mysqli_fetch_assoc($rez)){
                echo "<div class='row border border-success mb-2'>";
                echo "<div class='col-10'>";
                if($_SESSION['status']=='administrator')
                echo "{$red['idZanra']}: ";
                $upit="SELECT COUNT(*) as 'broj' from izdanjeZanr where idZanra='{$red['idZanra']}'";
                $red1=mysqli_fetch_assoc(mysqli_query($db,$upit));
                if($red1['broj']!=0) echo "<a href='izdanje_show.php?z={$red['idZanra']}'>";
                echo "{$red['nazivZanra']}";
                if($red1['broj']!=0) echo "</a>";
                echo "</div>";
                if($_SESSION['status']=='administrator'){
                    echo "<div class='col-1'><a class='btn btn-success m-1' href='zanr_update.php?id={$red['idZanra']}'>Izmena</a></div>";
                    if(!$red['obrisan'])
                    echo "<div class='col-1'><a class='btn btn-danger m-1' href='zanr_delete.php?id={$red['idZanra']}'>Brisanje</a></div>";
                    else echo "<div class='col-1'><a class='btn btn-warning m-1' href='zanr_delete.php?id={$red['idZanra']}'>Vrati</a></div>";
                }

                echo "</div>";
            }
            
            mysqli_close($db);
        ?>
    </div>
</body>
</html>