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
    }
    if(!isset($_GET['id'])){
        echo "<div class='alert alert-danger'>Izvođač nije izabran.</div>";
        echo "<a href='izvodjac_show.php'>Izvođači</a>";
        exit();
    }
    $id=$_GET['id'];
    $upit = "SELECT * FROM izvodjac WHERE idIzvodjaca='{$id}'";
    $rez = mysqli_query($db,$upit);
    if(!$rez){
        echo "<div class='alert alert-danger'>Izabran izvođač ne postoji.</div>";
        echo "<a href='izvodjac_show.php'>Izvođači</a>";
        exit();
    }
    $red = mysqli_fetch_assoc($rez);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izmena izvođača</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Izmena izvođača</h1>
    <hr>
    <div class="container">
        <form action="izvodjac_update.php?id=<?= $id?>" method="post">
                <div class="mb-3">
                    <label for="ime">Ime izvođača</label>
                    <input type="text" class="form-control" id="ime" name="ime" placeholder="Ime izvođača" value="<?=$red['ime']?>">
                </div>
                <div class="mb-3">
                    <label for="bio">Biografija izvođača</label>
                    <textarea class="form-control" id="bio" name="bio" placeholder="Biografija (nije obavezno)" rows="5"><?=$red['bio']?></textarea>
                </div>
                <button class="btn btn-primary">Sačuvaj</button>
            </form>
    <hr>
            <?php
                if(isset($_POST['ime'])){
                    extract($_POST);
                    if($ime!=""){
                        $upit = "UPDATE izvodjac SET ime='{$ime}',";
                        if(trim($bio=="")) $upit.="bio=NULL";
                        else $upit.="bio='{$bio}'";
                        $upit.=" WHERE idIzvodjaca='{$id}'";
                        mysqli_query($db,$upit);
                        if(mysqli_error($db)){
                            echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
                        }
                        else {
                            echo "<div class='alert alert-success'>Uspešna izmena!</div>";
                        }
                    }
                    else echo "Svi podaci su obavezni";
                }
            ?>
    </div>
    
</body>
</html>