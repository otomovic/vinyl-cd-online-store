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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodavanje izvođača</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Dodavanje izvođača</h1>
    <hr>
    <div class="container">
        <form action="izvodjac_create.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="ime" name="ime" placeholder="Ime izvođača">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="bio" name="bio" placeholder="Biografija (nije obavezno)" rows="5"></textarea>
                </div>
                <button class="btn btn-primary">Sačuvaj</button>
            </form>
    <hr>
            <?php
                if(isset($_POST['ime'])){
                    extract($_POST);
                    if($ime!=""){
                        $upit="";
                        if($bio==""){
                            $upit = "INSERT INTO izvodjac(ime) VALUES('{$ime}')";
                        }
                        else{
                            $upit = "INSERT INTO izvodjac(ime,bio) VALUES('{$ime}','{$bio}')";
                        }
                        
                        $db = konekcija();
                        mysqli_query($db,$upit);
                        if(mysqli_error($db)){
                            switch(mysqli_errno($db)){
                                case "1062":
                                    echo "<div class='alert alert-info'>Izvođač već postoji.</div>";
                                    break;
                                default:
                                    echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
                            }
                        }
                        else {
                            echo "<div class='alert alert-success'>Uspešan unos!</div>";
                        }
                    }
                    else echo "<div class='alert alert-danger'>Svi podaci su obavezni</div>";
                }
            ?>
    </div>
    
</body>
</html>