<?php
 $db_host = 'localhost';
 $db_navn = 'mag22071';
 $db_bruker = 'mag22071';
 $db_passord = 'mag2';
 $db_forbindelse = mysqli_connect($db_host, $db_bruker, $db_passord, $db_navn);

if (mysqli_connect_errno()) {
    die('Kunne ikke få kontakt med databaseserveren'. mysqli_connect_error());
}

if (isset($_POST['dyr'])){
    $dyrnavn = $_POST['dyr'];
    $queryh1 = htmlentities ("SELECT art, informasjon, latinsk FROM art_info WHERE art LIKE '%{$dyrnavn}%' 
        OR latinsk LIKE '%{$dyrnavn}%' ORDER BY art ASC;");
    $resultath1 = mysqli_query($db_forbindelse, $queryh1);
    $h1_text = mysqli_fetch_row($resultath1)[0];
    
    $querycount = "SELECT COUNT(art) AS NavnDyr FROM art_info WHERE art LIKE '%{$dyrnavn}%'";
    $resultatcount = mysqli_query($db_forbindelse, $querycount);
    $count = mysqli_fetch_row($resultatcount)[0];

    $mintekst = "";
    if ($result = mysqli_query($db_forbindelse, $queryh1)) {
        while ($row = mysqli_fetch_row($result)) {
            $mintekst .= "
            <div>
                <h1 class='resultatheader'>
                    <a class='resultatheader' href='rike.php?id={$row[0]}'>
                        {$row[0]}  ({$row[2]})
                    </a>
                </h1>
                <p class='undertekst'>{$row[1]}</p>
            </div>\n";
        }
        mysqli_free_result($result);
    }

    
    if ($h1_text == ''){
        $h1_text = "<h1>Det finnes ikke noe resultater i databasen vår</h1>";
    } 
}
$querymain = "SELECT art, informasjon, latinsk FROM art_info;";
$hovedtekst = "";
if ($result1 = mysqli_query($db_forbindelse, $querymain)) {
    while ($row = mysqli_fetch_row($result1)) {
        $hovedtekst .= "
        <div>
            <a href='rike.php?id={$row[0]}'>
                <h1 class='resultatheader'>{$row[0]} ({$row[2]})</h1>
            </a>
            <p class='undertekst'>{$row[1]}</p>
        </div>\n";
    }
    mysqli_free_result($result1);
}
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artsdatabase</title>
    <link rel="stylesheet" href="stilark/sokside.css">
    <script src="sokefelt/script.js" defer></script>
</head>
<body>
<div class="header">
    <div class="sokfelt">
        <div class="sitereload">
            <h3><a href='https://webkode.skit.no/~bas2301/PHP/Artsdatabase/Backup/Artsdatabase/main/index.php' class="headtxt whitetxt">Artsdatabase</a></h3>
        </div>
        <form action="index.php" method="post" id="dyrskjema" class="form">
            <input type="search" name="dyr" id="dyr" class="w3-input w3-border" placeholder="Søk" autocomplete="off" required>
            <input type="submit" class="w3-button w3-border" value="Søk etter dyr">
        </form>
    </div> 
        <div class="dataViewerDiv" id="dataViewerDiv">
            <ul id="dataViewer" class="w3-container whitetxt">
                    <!-- Hit list inserted from Javascript -->
            </ul>
        </div>
</div>
<main>
<div class="hero-image">
    <div class="hero-text">
        <div class="w3-container w3-row">
            <button class="button whitetxt"><a href="https://webkode.skit.no/~ole2602/html/Artsdatabase_test/rike.php?rike=Dyreriket">Dyreriket</a></button>
            <button class="button whitetxt"><a href="https://webkode.skit.no/~ole2602/html/Artsdatabase_test/rike.php?rike=Planteriket">Planteriket</a></button>
            <button class="button whitetxt"><a href="https://webkode.skit.no/~ole2602/html/Artsdatabase_test/rike.php?rike=Soppriket">Soppriket</a></button>
            <button class="button whitetxt"><a href="https://webkode.skit.no/~ole2602/html/Artsdatabase_test/rike.php">Velger</a></button>
        </div>
    </div>
</div>
<div class="artk">
    <?php 
        if (isset($count) && $count == 1){
            $er = "";
        } elseif (isset($count) && $count == 0){
            $count = "ingen";
            $er = "er";
        } else {
            $er = "er";
        }
        if (isset($_POST['dyr'])){
            echo "<p class='countxt'>Søkte på {$_POST['dyr']}, fant {$count} resultat{$er}</p>\n";
            echo $mintekst;
        } else {
            echo "<p class='countxt'>Alle innlegg</p>\n";
            echo $hovedtekst;
        }

        mysqli_close($db_forbindelse);
    ?>
</div>
</main>
</body>
</html>