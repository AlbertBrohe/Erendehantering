<?php
session_start();

if (isset($_POST['skicka'])) { //Om knappen är tryckt
    $emne = trim($_POST['emne']);
    $ovrigt = trim($_POST['ovrigt']); //Ta alla värden
    $prio = $_POST['prio'];
    
    // Connectar till databas
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "kundsupport";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_SESSION['name'])) { //om man är inloggad skickas formuläret
        $name = $_SESSION['name'];
        $query1 = "SELECT email FROM anvendare WHERE name='$name'";
        $result1 = $conn->query($query1);

        while ($rad = mysqli_fetch_assoc($result1)) { //kollar igenom vilket email skickaren hade, vilken tid den skickades och skickar ticket
            $email = $rad['email'];
            $time = date('Y-m-d H:i:s');
            $query = "INSERT INTO problem (Prioritet, Emne, Status, Ansvarig, Inskickat, Beskrivning) VALUES ($prio, '$emne', 'Öppen', '$email', '$time', '$ovrigt')";
            $result = $conn->query($query);
        }
    } else {
            echo("<h4>Logga in för att skicka feedback!</h4>"); //meddelar om man inte är inloggad och skickar inte
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kundsupport</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.cdnfonts.com/css/outfit" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/fira-mono" rel="stylesheet">
</head>
<body>
    <div class="navbar">
        <div class="namn"><?php if (isset($_SESSION['name'])) { echo('Inloggad som: ' . $_SESSION['name']); } else { echo 'Inloggad som: Gäst'; } ?></div>
        <div onclick="document.location='login.php'" class="login"> <!-- Skickar till login sidan -->
            <p><?php if (isset($_SESSION['name'])) { echo 'Logga Ut'; } else { echo 'Logga in'; } ?></p> <!-- Logga in om utloggad och logga ut om inloggad -->
        </div>
    </div>

    <div class="landing">
        <h1>Skicka Feedback!</h1>
    </div>

    <div class="ner"><p>Meddela Oss!</p><a href="#section"><i class="fa fa-arrow-down"></i></a></div>
    
    <section>
        <div class="formulerer" id="section">
            <div class="farger">
                <div class="farg">
                    <div class="green"></div>
                    <div class="icon"><a href="#section"><i class="fa fa-pencil-square-o"></i></a></div>
                </div>
              
                <div class="farg">
                    <div class="cyan"></div>
                    <div class="icon"><a href="#section"><i class="fa fa-envelope-o"></i></a></div>
                </div>
            
                <div class="farg">
                    <div class="blue"></div>
                    <div class="icon"><a href="#section"><i class="fa fa-phone"></i></a></div>
                </div>
            </div>
            <div class="formula">
                <form action="index.php" method="post">
                    <div class="row1">
                        <div class="col1">
                            <label for="emne">Ämne: (Max 20 tecken)</label>
                            <input type="text" name="emne" id="emne" maxlength="20" required> <!-- tar max 20 tecken -->
                        </div>
                        <div class="col2">
                            <label for="prio">Prioritet:</label>
                            <select name="prio" id="prio" required>
                                <option value="" disabled selected>Välj</option> <!-- använder ett disabled option så man måste välja -->
                                <option value="4">Låg</option>
                                <option value="3">Medium</option>
                                <option value="2">Hög</option>
                                <option value="1">Akut</option>
                            </select>
                        </div>
                    </div>
                    <label for="ovrigt">Övrigt: (Max 250 tecken)</label>
                    <textarea name="ovrigt" id="ovrigt" cols="30" rows="7" maxlength="250" required></textarea> <!-- max 250 tecken -->
                    <input type="submit" name="skicka" id="skicka" value="Skicka">
                </form>
            </div>
            <div class="info">
                <div class="kontakt"><i class="fa fa-envelope"></i><p>Admin@gmail.com</p></div>
                <div class="kontakt"><i class="fa fa-phone"></i><p>070 123 45 67</p></div>
            </div>
        </div>
    </section>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function(event) { 
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);                         // Gör att positionen på sidan sparas när man skickar
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>
