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
            $name = $_POST['username'];
            $pass = $_POST['password'];
            
            $sql = "SELECT username FROM user";
            $result = $conn->query($sql);

            $sql = "SELECT username, password FROM user";
            $result = $conn->query($sql);
            
            $found = false;
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()) {
                    if($row["username"]==$name && $row["password"] == $pass){
                        echo $row["username"];
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