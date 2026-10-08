<?php

    // Functie: programma login OOP 

    // Auteur: Studentnaam

    require_once('classes/User.php');

    // Databaseverbinding
    // $pdo = new PDO(
    //     "mysql:host=localhost;dbname=login_oop",
    //     "root",
    //     ""
    // );

    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user = new User();

    $errors=[];

    // Is de register button aangeklikt?

    if(isset($_POST['register-btn'])){

        // Gegevens uit formulier halen

        $user->username = $_POST['username'];

        $user->setPassword($_POST['password']);

        // Validatie gegevens
        $errors = $user->validateUser();

        // Hoe???

        // Test of er geen errors zijn

        if(count($errors) == 0){
			echo "<script>alert('User registered')</script>";

            // Register user

            $errors = $user->registerUser();

        }

        if(count($errors) > 0){

            $message = "";

            foreach ($errors as $error) {

                $message .= $error . "\n";

            }

            echo "

            <script>alert('" . $message . "')</script>

            <script>window.location = 'register_form.php'</script>";

			echo "<script>alert('" . $message . " ')</script>";

        } else {

            echo "

            $user->regi

                <script>alert('" . "User registerd" . "')</script>

                <script>window.location = 'login_form.php'</script>";

        }
    }

?>

<!DOCTYPE html>

<html lang="en">

<body>

        <h3>PHP - PDO Login and Registration</h3>

        <hr/>

            <form action="" method="POST">  

                <h4>Register here...</h4>

                <hr>

                <div>

                    <label>Username</label>

                    <input type="text" name="username" />

                </div>

                <div>

                    <label>Password</label>

                    <input type="password" name="password" />

                </div>

                <br />

                <div>

                    <button type="submit" name="register-btn">Register</button>

                </div>

                <a href="index.php">Home</a>

            </form>

</body>

</html>
