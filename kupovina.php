<?php
require_once("funkcije.php");
  $db=konekcija();
  if(!$db) exit();
  session_start();
  if(!isset($_POST['moze']) or $_POST['moze']!=1 or $_SESSION['status']=='administrator')
  exit();
  $korpa=$_SESSION['korpa'];
  foreach($korpa as $proizvod){
    $upit="SELECT idIzdanja,kolicina FROM izdanje WHERE idIzdanja='{$proizvod[0]}'";
    $rez=mysqli_query($db,$upit);
    $red=mysqli_fetch_assoc($rez);
    if(intval($proizvod[1])>intval($red['kolicina'])){
      echo "<div class='alert alert-danger'>Nema dovoljno proizvoda na stanju.</div>";
      exit();
    }
  }
  $upit="INSERT INTO kupovina(idKorisnika) VALUES('{$_SESSION['id']}')";
  mysqli_query($db,$upit);
  if(mysqli_error($db)){
    echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
    exit();
  }
  $idKupovine=mysqli_insert_id($db);
  foreach($korpa as $proizvod){
    $upit="INSERT INTO specifikacija VALUES('{$idKupovine}','{$proizvod[0]}','{$proizvod[1]}')";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
      echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
      exit();
    }
    $kolicina=mysqli_fetch_assoc(mysqli_query($db,"SELECT kolicina FROM izdanje WHERE idIzdanja='{$proizvod[0]}'"))['kolicina'];
    $novaKolicina=intval($kolicina)-intval($proizvod[1]);
    $upit="UPDATE izdanje SET kolicina={$novaKolicina}";
    if($novaKolicina==0) $upit.=", naStanju='0'";
    $upit.=" WHERE idIzdanja='{$proizvod[0]}'";
    mysqli_query($db,$upit);
    if(mysqli_error($db)){
      echo "<div class='alert alert-danger'>Došlo je do greške<br>[".mysqli_errno($db)."]: ".mysqli_error($db)."</div>";
      exit();
    }
  }
  echo "<div class='alert alert-success'>Uspešna kupovina!</div>";
  $_SESSION['korpa']=array();
?>