<?php
    require_once("funkcije.php");
    $db=konekcija();
    if(!$db)exit();
    session_start();
    if(adminProvera()){
        header("location:korisnik_show.php");
    }
    else if(korisnikProvera())header("location:izdanje_show.php");
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
            margin-top:20%;
            transform:translatey(-50%);
        }
    </style>
    <title>Početna stranica</title>
</head>
<body>
<div class="container">
        <h1>Prijavite se</h1>
        <hr>
        <form action="index.php" method="post">
            <div class="form-outline mb-4">
                <input type="email" id="email" name ="email" class="form-control" placeholder="email"/>
            </div>
            <div class="form-outline mb-4">
                <input type="password" id="lozinka" name="lozinka" class="form-control" placeholder="lozinka"/>
            </div>
            <button class="btn btn-primary btn-block mb-4">Prijavi se</button>
        </form>
    
    <?php
        if(isset($_POST['email']) and isset($_POST['lozinka'])){
            extract($_POST);
            if($email!="" and $lozinka!=""){
                $upit="SELECT * FROM korisnik WHERE email='{$email}'";
                $rez=mysqli_query($db, $upit);
                if(mysqli_num_rows($rez)==1){
                    $red=mysqli_fetch_assoc($rez);
                    if($lozinka==$red['lozinka']){
                        session_start();
                        $_SESSION['id']=$red['idKorisnika'];
                        $_SESSION['podaci']=$red['ime']." ".$red['prezime'];
                        $_SESSION['status']=$red['status'];
                        $_SESSION['korpa']=array();
                        if($red['status']=="administrator"){
                            header("location:korisnik_show.php");
                        }
                        else header("location:izdanje_show.php");

                    }else
                        echo "<div class='alert alert-danger'>Uneta je pogrešna lozinka.</div>";
                }else
                    echo "<div class='alert alert-danger'>Ne postoji korisnik sa email adresom '{$email}'</div>";
            }else
                echo "<div class='alert alert-danger'>Svi podaci su obavezni</div>";
        }
    
    ?>
    </div>
</body>
</html>