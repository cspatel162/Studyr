<html>
    <head>
        <title>Welcome</title>
    </head>
    <body>
<!--        open the database-->
        <?php
            $servername = "localhost";
            $username = "chens16";
            $password = "websysproject";
            $dbname = "term_project";

            // Create connection
            $conn = new mysqli($servername, $username, $password,$dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
        ?>
        
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