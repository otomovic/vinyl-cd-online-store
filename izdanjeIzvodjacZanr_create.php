<?php
    require_once("funkcije.php");
    $db=konekcija();
    if(isset($_POST["nizIzvodjaca"]) and isset($_POST['nizZanrova']) and isset($_POST['naziv']) and isset($_POST['godina']) and isset($_POST['kolicina']) and isset($_POST['format']) and isset($_POST['tip']) and isset($_POST['cena'])){
        extract($_POST);
        $nizIzvodjaca=json_decode(stripslashes($nizIzvodjaca));
        $nizZanrova=json_decode(stripslashes($nizZanrova));
        $slika=$_FILES['img'];
        $targetDir = "uploads/";
        $fileName = basename($slika['name']);
        $targetFilePath = $targetDir . $fileName;
        if(move_uploaded_file($_FILES["slika"]["tmp_name"], $targetFilePath)){
        if($naziv!="" and $godina!="" and $kolicina!="" and $format!="0" and $tip!="0" and $cena!=""){
            $upit = "INSERT INTO izdanje(naziv, godina, tip, format, kolicina, slika, cena, naStanju) VALUES('{$naziv}','{$godina}','{$tip}','{$format}','{$kolicina}','{$fileName}', '{$cena}', ";
            if($kolicina>0){
                $upit.="'1')";
            }
            else $upit.="'0')";  
            mysqli_query($db,$upit);
            if(mysqli_error($db)){
                switch(mysqli_errno($db)){
                    case "1062":
                        echo "<div class='alert alert-info'>Izdanje sa odabranom slikom već postoji.</div>";
                        break;
                    default:
                        echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
                }
            }
            else {
                $greska=0;
                $id=mysqli_insert_id($db);
                foreach($nizIzvodjaca as $izvodjac){
                    $upit="INSERT INTO izdanjeIzvodjac VALUES('{$id}','{$izvodjac}')";
                    mysqli_query($db,$upit);
                    if(mysqli_error($db)){
                        $greska=1;
                        break;
                    }
                    }
                foreach($nizZanrova as $zanr){
                    $upit="INSERT INTO izdanjeZanr VALUES('{$id}','{$zanr}')";
                    mysqli_query($db,$upit);
                    if(mysqli_error($db)){
                        $greska=1;
                        break;
                    }
                    }
                    if($greska==0){
                        echo "<div class='alert alert-success'>Uspešno dodavanje!</div>";
                    }
                    else echo "<div class='alert alert-danger'>Neuspešno dodavanje</div>";
                    
            }
            
            }
            else echo "<div class='alert alert-danger'>Svi podaci su obavezni</div>";
        }
        else echo "<div class='alert alert-danger'>Došlo je do greške pri dodavanju slike.</div>";
    }
    else echo "<div class='alert alert-danger'>Nisu predati svi podaci</div>";
?>