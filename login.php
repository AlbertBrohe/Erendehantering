<?php
    session_start(); // Startar en session

    if (isset($_GET['signup_success'])) {
        echo "<p>Registration successful! Please log in.</p>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        // connectar till databas
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "kundsupport";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die ("Connection failed: " . $conn->connect_error);
        }

        // checkar avändare
        $query = "SELECT * FROM anvendare WHERE name='$name' AND password='$password' AND email='$email'";
        $result = $conn->query($query);


        //kollar om inloggning finns i databasen
        if ($result->num_rows == 1) {
            $row = mysqli_fetch_assoc($result);
            if($row['nivo'] > 1){
                $_SESSION['name'] = $name;
                header("Location: admin.php");
            }else{
                $_SESSION['name'] = $name; //skapar seesionsanvändarnamn
                header("Location: index.php");
            }
        } else {
            header("Location: login.php");
            echo "Login failed!";
            echo "<p>Fel Användarnamn, Lösenord eller E-post</p>";
        }
        

        $conn->close();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga in</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.cdnfonts.com/css/outfit" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/fira-mono" rel="stylesheet">
</head>
<body>
    <div class="login">
        <div class="top">
            <h2>Logga In</h2>
        </div>
        <div class="bot">
            <form action="login.php" method="post">
                <div class="row">
                    <label for="name">Användarnamn:</label>
                    <input type="text" id="name" name="name" placeholder="Namn">
                </div>
                <div class="row">
                    <label for="email">E-post:</label>
                    <input type="email" id="email" name="email" placeholder="Exempel@gmail.com">
                </div>
                <div class="row">
                    <label for="password">Lösenord:</label>
                    <input type="password" id="password" name="password" placeholder="123456789">
                </div>
                <div class="row">
                    <input type="submit" id="btn" name="btn" value="Logga in"><br>
                    <a href="signup.php">Har inget konto? Registrera dig här</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>