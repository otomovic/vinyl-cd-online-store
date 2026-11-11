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
    <title>Dodavanje izdanja</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        nizIzvodjaca=[];
        nizZanrova=[];
        var img="";
        isImage=false;
        $(function(){
            $('#slika').change(function(){
			    img = this.files[0],
                fileName = img.name,
                fileSize = img.size;
                fileType = img.type;
                if(fileType.includes("image"))
                isImage=true;
		})
        })

    function dodajIzvodjaca(){
        if($("#izvodjaci").val()!="0"){
            postoji=false;
            $("#dodatiIzvodjaci > option").each(function() {
                if($("#izvodjaci").val()==$(this).val())
                postoji=true;
            })
            if(!postoji){
                $("#dodatiIzvodjaci").append("<option value='"+$("#izvodjaci option:selected").val()+"'>"+$("#izvodjaci option:selected").text()+"</option>");
                nizIzvodjaca.push($("#izvodjaci option:selected").val());
            }
        }
    }
            
            function obrisiIzvodjaca(){
                $("#dodatiIzvodjaci option:selected").each(function(){
                    nizIzvodjaca.splice(nizIzvodjaca.indexOf($(this).val()),1);
                })
                $('option:selected', $("#dodatiIzvodjaci")).remove();
            }

            function dodajZanr(){
                if($("#zanrovi").val()!="0"){
                    postoji=false;
                    $("#dodatiZanrovi > option").each(function() {
                        if($("#zanrovi").val()==$(this).val())
                        postoji=true;
                    });
                    if(!postoji){
                        $("#dodatiZanrovi").append("<option value='"+$("#zanrovi").val()+"'>"+$("#zanrovi option:selected").text()+"</option>");
                        nizZanrova.push($("#zanrovi option:selected").val());
                    }
                    
                }
            }
            
            function obrisiZanr(){
                $("#dodatiZanrovi option:selected").each(function(){
                    nizZanrova.splice(nizZanrova.indexOf($(this).val()),1);
                })
                $('option:selected', $("#dodatiZanrovi")).remove();
            }
            function sacuvaj(){
                if(isImage){
                    if(nizIzvodjaca.length!=0 && nizZanrova.length!=0){
                        const endpoint = "izdanjeIzvodjacZanr_create.php";
                        const formData = new FormData(forma);
                        formData.append("img",img);
                        formData.append("nizIzvodjaca",JSON.stringify(nizIzvodjaca));
                        formData.append("nizZanrova",JSON.stringify(nizZanrova));
                        $.ajax({
                            type: "POST",
                            url: endpoint,
                            enctype: 'multipart/form-data',
                            data: formData,
                            processData: false,
                            contentType: false
                        }).done( function (response) {
                                $("#odgovor").html(response);
                            }
                        );
                    }
                    else{
                        $("#odgovor").addClass("alert alert-danger").html("Unesite barem jednog izvođača i žanr!");
                    }
                    
                }
                else $("#odgovor").addClass("alert alert-danger").html("Slika nije izabrana / ispravna!");
            }
                
            
    </script>
    <h1>Dodavanje izdanja</h1>
    <hr>
    <div class="container">
        <form method="post" enctype="multipart/form-data" id="forma">
                <div class="mb-3">
                    <input class="form-control" type="text" id="naziv" name="naziv" placeholder="Naziv izdanja">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="number" id="godina" name="godina" placeholder="Godina" min="1900" max="3000">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="izvodjaci" id="izvodjaci" onchange="dodajIzvodjaca()">
                        <option value="0">Dodajte izvođača</option>
                        <?php
                            $upit="SELECT idIzvodjaca,ime FROM izvodjac ORDER BY ime";
                            $rez=mysqli_query($db,$upit);
                            while($red=mysqli_fetch_assoc($rez)){
                                echo "<option value='{$red['idIzvodjaca']}'>{$red['ime']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="dodatiIzvodjaci" id="dodatiIzvodjaci" multiple>

                    </select>
                    <button class="btn btn-danger my-3" type="button" onclick="obrisiIzvodjaca()">Ukloni izvođača</button>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="zanrovi" id="zanrovi" onchange="dodajZanr()">
                        <option value="0">Dodajte žanr</option>
                        <?php
                            $upit="SELECT idZanra,nazivZanra FROM zanr ORDER BY idZanra";
                            $rez=mysqli_query($db,$upit);
                            while($red=mysqli_fetch_assoc($rez)){
                                echo "<option value='{$red['idZanra']}'>{$red['nazivZanra']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="dodatiZanrovi" id="dodatiZanrovi" multiple>

                    </select>
                    <button class="btn btn-danger my-3" type="button" onclick="obrisiZanr()">Ukloni žanr</button>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="number" id="kolicina" name="kolicina" placeholder="Količina" min="0">
                </div>
                <div class="mb-3">
                    <select class="form-select" name="tip" id="tip">
                        <option value="0">Tip izdanja</option>
                        <option value="album">Album</option>
                        <option value="single">Single</option>
                        <option value="compilation">Kompilacija</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="format" id="format">
                        <option value="0">Format</option>
                        <option value="vinyl">Ploča</option>
                        <option value="cd">CD</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="slika">Slika omota</label>
                    <input class="form-control" type="file" name="slika" id="slika">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="number" id="cena" name="cena" placeholder="Cena (RSD)" min="1">
                </div>
                <button class='btn btn-primary' type="button" onclick='sacuvaj()'>Sačuvaj</button>
                
            </form>
            <hr>
            <div id="odgovor"></div>
    </div>
</body>
</html>