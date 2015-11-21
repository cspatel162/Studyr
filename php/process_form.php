<?php
require 'connect.php';
?>

<html>
    <head>
        <title>Welcome</title>
    </head>
    <body>
        
<!--        add to db if not there otherwise add-->
        <?php
            $name = $_POST['email2'];
            $pass = $_POST['password'];
            
            $sql = "SELECT email FROM users";
            $result = $conn->query($sql);

            $sql = "SELECT email, password FROM users";
            $result = $conn->query($sql);
            
            $found = false;
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    if($row["email"]==$name && $row["password"] == $pass){
                        echo $row["email"];
                        echo $row["password"];
                        $found = true;
                        break;
                    }
                }
            }

            if($found)
                echo "found";
            else 
                echo "not found";
            
            $conn->close();
        ?>
        <br>

    </body>
</html>