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
    <title>Dodavanje korisnika</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Dodavanje korisnika</h1>
    <hr>
    <div class="container">
        <form action="korisnik_create.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="ime" name="ime" placeholder="Ime">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="prezime" name="prezime" placeholder="Prezime">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email adresa">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="lozinka" name="lozinka" placeholder="Lozinka">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" id="adresa" name="adresa" placeholder="Adresa">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="status" id="status">
                        <option value="0">Status</option>
                        <option value="korisnik">Korisnik</option>
                        <option value="administrator">Administrator</option>
                    </select>
                </div>
                <button class="btn btn-primary">Sačuvaj</button>
            </form>
    <hr>
            <?php
                if(isset($_POST['ime'])){
                    extract($_POST);
                    if($ime!="" and $prezime!="" and $email!="" and $lozinka!="" and $adresa!="" and $status!="0"){
                        $upit = "INSERT INTO korisnik(ime,prezime,email,lozinka,adresa,status) VALUES('{$ime}','{$prezime}','{$email}','{$lozinka}','{$adresa}','{$status}')";                        
                        $db = konekcija();
                        mysqli_query($db,$upit);
                        if(mysqli_error($db)){
                            switch(mysqli_errno($db)){
                                case "1062":
                                    echo "<div class='alert alert-info'>Korisnik sa unetom email adresom već postoji.</div>";
                                    break;
                                default:
                                    echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
                            }
                        }
                        else {
                            echo "<div class='alert alert-success'>Uspešan unos!</div>";
                        }
                    }
                    else echo "Svi podaci su obavezni";
                }
            ?>
    </div>
    
</body>
</html>