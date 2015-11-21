<?php //we can include other PHP Files here to keep the index as clear as possible 
include_once 'php/connect.php';
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    <head>

    <body>
        <form action="php/calendar.php" method="post">
            Username: <input type="text" name="email2"><br>
            Password: <input type="password" name="password">
            <input type="submit" value="submit">
        </form>
        
        <br>
        
        <form action="php/signup.php" method="post">
            Username: <input type="text" name="email"><br>
            Password: <input type="password" name="newpassword">
            <input type="submit" value="submit">
        </form>
        
        <section class="content">
            <a href="php/calendar.php">Calendar Link </a>
            <p></p>
            <a href="php/splashpage.php">Splash Page after login </a>
        </section>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    </body>
</html>