<?php
    require_once("funkcije.php");
    $db=konekcija();
                    
        if(isset($_POST['naziv']) and isset($_POST['nizIzvodjaca']) and isset($_POST['nizZanrova']) and isset($_POST['id'])){
            extract($_POST);
            $nizIzvodjaca=json_decode(stripslashes($nizIzvodjaca));
            $nizZanrova=json_decode(stripslashes($nizZanrova));
            $fileType="";
            if($naziv!="" and $godina!="" and $kolicina!="" and $format!="0" and $tip!="0" and $izvodjaci!="" and $zanrovi!="" and $cena!=""){
                if(empty($_FILES['slika']['name']) or move_uploaded_file($_FILES["slika"]["tmp_name"], "uploads/".$_FILES["slika"]["name"])){
                    $upit = "UPDATE izdanje SET naziv='{$naziv}',godina='{$godina}',tip='{$tip}',format='{$format}',kolicina='{$kolicina}',cena='{$cena}', kolicina='{$kolicina}',naStanju=";
                    if($kolicina>0){
                        $upit.="'1'";
                    }
                    else $upit.="'0'";
                    if(!empty($_FILES['slika']['name']))
                    $upit.=",slika='{$_FILES["slika"]["name"]}'";
                    $upit.=" WHERE idIzdanja='{$id}'";
                    $db = konekcija();
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
                    else{
                        $upit="DELETE FROM izdanjeIzvodjac WHERE idIzdanja='{$id}'";
                        mysqli_query($db,$upit);
                        $upit="DELETE FROM izdanjeZanr WHERE idIzdanja='{$id}'";
                        mysqli_query($db,$upit);
                        $greska=0;
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
                                echo "<div class='alert alert-success'>Uspešna izmena!</div>";
                            }
                            else echo "<div class='alert alert-danger'>Neuspešna izmena</div>";
                    }
                }
            }
            else echo "<div class='alert alert-danger'>Svi podaci su obavezni!</div>";
        }
        else echo "<div class='alert alert-danger'>Nisu uneti svi podaci!</div>";
?>