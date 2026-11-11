<?php
echo "<div class='alert alert-secondary'>";
    echo "<div class='row'>";
        echo "<div class='col-8'>";
        if(isset($_SESSION['status'])){
            if($_SESSION['status']=="administrator"){
                echo "<a class='btn btn-default' href='korisnik_show.php'>Korisnici</a>";
                echo "<a class='btn btn-default' href='kupovina_show.php'>Narudžbine</a>";
            }
            if($_SESSION['status']=='korisnik')
            echo "<a class='btn btn-default' href='kupovina_show.php'>Moje narudžbine</a>";
                echo "<a class='btn btn-default' href='izdanje_show.php'>Izdanja</a>";
                echo "<a class='btn btn-default' href='izvodjac_show.php'>Izvođači</a>";
                echo "<a class='btn btn-default' href='zanr_show.php'>Žanrovi</a>";
                echo "</div>";
                echo "<div class='col-4' style='text-align:right'>";
                echo "<span class='btn btn-default'>";
                echo "{$_SESSION['podaci']} ({$_SESSION['status']}) | ";
                if($_SESSION['status']=="korisnik")
                echo "<a href='korpa.php'>Korpa</a> | ";
                echo "<a href='logout.php'>Odjava</a></span>";
            }
        echo "</div>";
    echo "</div>";
echo "</div>";
?>