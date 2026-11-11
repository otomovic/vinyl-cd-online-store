<?php
function konekcija(){
    mysqli_report(MYSQLI_REPORT_OFF);
    $db=@mysqli_connect("localhost", "root", "", "prodavnica");
    if(!$db){
        echo "Neuspela konekcija na bazu<br>";
        echo mysqli_connect_error()."<br>".mysqli_connect_errno();
        return false;
    }
    mysqli_query($db, "SET NAMES utf8");
    return $db;
}

function login(){
    if(isset($_SESSION['id']))return true;
    else{
        echo "<h2>Morate biti prijavljeni da viste videli ovu stranicu</h2>";
        echo "<a href='index.php'>Prijava</a>";
        return false;
    }
}

function loginProvera(){
    return isset($_SESSION['id']);
}

function adminProvera(){
    if(loginProvera())
    return $_SESSION['status']=="administrator";
    return false;
}

function korisnikProvera(){
    if(loginProvera())
    return $_SESSION['status']=="korisnik";
    return false;
}
?>