<?php
session_start(); //startar session

if (!isset($_SESSION['name']) || $_SESSION['name'] !== "Admin") { //kollar om användaren har ett användarnamn och om det är Admin
    header("Location: login.php"); //tillbaka till inloggning annars
}

// connectar till databas
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "kundsupport";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname); //skapar anslutning

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //kontrollerar anslutning
}

$filter = 'Öppna';
$query = "SELECT * FROM problem WHERE Status = 'Öppen' ORDER BY Prioritet ASC"; //visar öppna tickets vid öppning av sidan

if (isset($_POST['choose'])) { // Hanterar ändring av filter baserat på användarens val 
    $filter = $_POST['choose'];
    if ($filter == 'Historik') {
        $query = "SELECT * FROM problem WHERE Status = 'Stängd' ORDER BY Prioritet ASC";
    } else {
        $query = "SELECT * FROM problem WHERE Status != 'Stängd' ORDER BY Prioritet ASC";
    }
} elseif (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    if ($filter == 'Historik') {
        $query = "SELECT * FROM problem WHERE Status = 'Stängd' ORDER BY Prioritet ASC";
    } else {
        $query = "SELECT * FROM problem WHERE Status != 'Stängd' ORDER BY Prioritet ASC";
    }
}

$result = $conn->query($query); // Utför SQL-frågan och lagrar resultatet

if (isset($_POST['steng'])) { // Hanterar stängning av ett problem
    $id = $_POST['id']; 
    $close = "UPDATE problem SET Prioritet = 5, Status = 'Stängd' WHERE id=$id"; //ger ticket stängd värden

    if ($conn->query($close) === TRUE) { //uppdaterar ticket till stängd
        header("Location: Admin.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Logga ut logik
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://fonts.cdnfonts.com/css/outfit" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/fira-mono" rel="stylesheet">

</head>
<body>
    <div class="navbar">
        <div class="namn">
            Inloggad som: <?=$_SESSION['name']?> <!-- visar admin namn -->
        </div>
        <div onclick="document.location='?action=logout'" class="login">
            <h3><?php if (isset($_SESSION['name'])) { echo 'Logga Ut'; } else { echo 'Logga in'; } ?></h3> <!-- visa logga ut eller logga in  -->
        </div>
    </div>

    <div class="main">
        <div class="tickets">
            <div class="toppen">
                <div class="title"><h3>Tickets:</h3></div>
                <form action="admin.php" method="post" id="chooseForm">
                    <select name="choose" id="choose" onchange="this.form.submit()">
                        <option value="Aktiva" <?php if ($filter == 'Öppna') echo 'selected'; ?>>Öppna</option> <!-- använder filter så sidan inte byter tillbaka till fel default option när man submitar formet med selecten -->
                        <option value="Historik" <?php if ($filter == 'Historik') echo 'selected'; ?>>Historik</option>
                    </select>
                </form>
            </div>
            <div class="ticketlist">
            <?php while ($row = mysqli_fetch_assoc($result)) { //gör tickets
                $id = $row['id'];
                if ($row['Prioritet'] == 1) { $backgroundColor = 'red'; } //ger färg beroende på hur hög prioritet som ticketen har
                elseif ($row['Prioritet'] == 2) { $backgroundColor = 'orange'; } 
                elseif ($row['Prioritet'] == 3) { $backgroundColor = 'yellow'; } 
                elseif ($row['Prioritet'] == 4) { $backgroundColor = 'green'; } 
                elseif ($row['Prioritet'] == 5) { $backgroundColor = 'gray'; } ?>
                <div class="holder">
                    <div class="emne">
                        <h4><?=$row['Emne']?></h4> <!-- visar vad det handlar om -->
                    </div>
                    <div class="venster">
                        <p>Från: <?=$row['Ansvarig']?></p>
                        <p><?=$row['Status']?></p>
                        <div class="prio" style="background: <?=$backgroundColor?>;"></div> <!-- använder bakgrunden från prioritet -->
                        <form action="admin.php" method="post">
                            <input type="hidden" name="selected_id" value="<?=$id?>"> <!-- sparar id -->
                            <input type="hidden" name="filter" value="<?=$filter?>"> <!-- sparar filter -->
                            <input type="submit" id="oppna" name="oppna" value="Detaljer"> <!-- knapp för att se detaljer på ticketen -->
                        </form>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
        <?php if (isset($_POST['oppna']) && isset($_POST['selected_id'])) { //om knappen trycks och id finns
            $id = $_POST['selected_id'];
            $froga = "SELECT * FROM Problem WHERE id=$id"; //tar informationen från det valda id som sparades
            $info = $conn->query($froga);
            while ($rad = mysqli_fetch_assoc($info)) {
                if ($rad['Prioritet'] == 1) { $priori = "Akut"; } 
                elseif ($rad['Prioritet'] == 2) { $priori = "Hög"; } //skriver ut prioritet med ord baserat på siffrorna
                elseif ($rad['Prioritet'] == 3) { $priori = "Medium"; } 
                elseif ($rad['Prioritet'] == 4) { $priori = "Låg"; } 
                elseif ($rad['Prioritet'] == 5) { $priori = "Ingen Prioritet"; } ?>
                <div class="meny">
                    <div class="title"><h2>Meny</h2></div>
                    <div class="menystuff">
                        <div class="information">
                            <div class="tktname"><h2>Ämne: <?=$rad['Emne']?></h2></div> <!-- matar in all information till fälten -->
                            <div class="ansvar">Från: <?=$rad['Ansvarig']?></div>
                            <div class="prioriteten">Prioritet: <?=$priori?></div>
                            <div class="state">Status: <?=$rad['Status']?></div>
                            <div class="beskrivningen">Beskrivning: <?=$rad['beskrivning']?></div>
                        </div>
                        <?php if ($rad['Status'] != 'Stängd') { ?> <!-- om ticketen inte är stängd finns en knapp som stänger ticket -->
                        <form action="admin.php" method="post">
                            <input type="hidden" Name="id" Value="<?=$rad['id']?>">
                            <input type="hidden" name="filter" value="<?=$filter?>">
                            <input type="submit" id="steng" name="steng" Value="Stäng Ticket">
                        </form>
                        <?php } else { ?>
                        <p class="stangd-text">Stängd ticket</p> <!-- är ticket stängd visas denna grå text -->
                        <?php } ?>
                    </div>
                </div>
            <?php } 
        } else { ?>
            <div class="meny">
                <div class="title"><h2>Meny</h2></div>
                <div class="menystuff">
                    <div class="noinfo"><h3>Ingen Ticket Vald.</h3></div> <!-- har ingen ticket valts visas detta istället -->
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
<?php
?>
