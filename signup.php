<?php
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
            die("Connection failed: " . $conn->connect_error);
        }

        // kollar om användare redan finns
        $check_query = "SELECT * FROM anvendare WHERE name='$name' AND email='$email'";
        $check_result = $conn->query($check_query);

        if ($check_result->num_rows > 0) {
            echo "Username or email already exists.";
            exit();
        }

        // registrerar användren i databasen
        $insert_query = "INSERT INTO anvendare (name, password, email) VALUES ('$name', '$password','$email')";
        
        if ($conn->query($insert_query) === TRUE) {
            echo "nya användare skapad";
            // Redirectar till login pagen
            header("Location: login.php?signup_success=1");
            exit();

        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
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
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.cdnfonts.com/css/outfit" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/fira-mono" rel="stylesheet">
</head>
<body>
    <div class="signup">
        <div class="top">
            <h2>Registrera dig</h2>
        </div>
        <div class="bot">
            <form action="signup.php" method="post">
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
                    <input type="submit" id="btn" name="btn" value="Registrera dig"><br>
                    <a href="login.php">Har du redan ett konto? Logga in här</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>