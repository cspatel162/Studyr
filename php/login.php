<?php //we can include other PHP Files here to keep the index as clear as possible 
include_once 'connect.php';
?>
<html>
    <head>
        <title>Login or Register - Studyr</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    </head>

    <body>
        <section class="rightheader">Studyr</section>
        <section id="tabs">
          <ul>
            <li><a href="#tabs-1">Login</a></li>
            <li><a href="#tabs-2">Register</a></li>
          </ul>
          <section id="tabs-1">
            <form action="calendar.php" method="post">
                <ul>
                    <li class="sub"><ul>
                        <li>Email: </li>
                        <li>Password: </li>
                    </ul></li>
                    <li class="sub"><ul>
                        <li><input type="text" name="email2"></li>
                        <li><input type="password" name="password"></li>
                        <li><input class="enter" type="submit" value="Submit"></li>
                    </ul></li>
                </ul>
            </form>
          </section>
          <section id="tabs-2">
            <form onsubmit="return confirm(this)" action="signup.php" method="post">
                <ul>
                    <li class="sub"><ul class="labels">
                        <li id="fname">First name: </li>
                        <li id="lname">Last name: </li>
                        <li id="email">Email address: </li>
                        <li id="echeck">Confirm email: </li>
                        <li id="pw">Password: </li>
                        <li id="pwcheck">Confirm password: </li>
                    </ul></li>
                    <li class="sub"><ul>
                        <li><input type="text" name="fname"></li>
                        <li><input type="text" name="lname"></li>
                        <li><input type="text" name="email"></li>
                        <li><input type="text" name="email_check"></li>
                        <li><input type="password" name="newpassword"></li>
                        <li><input type="password" name="pass_check"></li>
                        <li><input class="enter" type="submit" value="Submit"></li>
                    </ul></li>
                </ul>
            </form>
          </section>
        </section>
        <script>
            $(function() {
                $( "#tabs" ).tabs();
            });
            function validateName(fname, lname){
                document.getElementById("fname").className = "";                    
                document.getElementById("lname").className = "";
                var reason = "";
                if(fname == ""){
                    reason+= "enter first name\n";
                    document.getElementById("fname").className = "error";
                }
                if(lname == ""){
                    reason+= "enter last name\n";
                    document.getElementById("lname").className = "error";
                }
                return reason;
            }
            function validateEmail(email, check){
                document.getElementById("email").className = "";                    
                document.getElementById("echeck").className = "";
                if(email == '' || check == ''){
                    document.getElementById("email").className = "error";
                    return "enter and confirm email address\n"
                }
                if(email != check){                    
                    document.getElementById("email").className = "error";                    
                    document.getElementById("echeck").className = "error";
                    return "emails do not match\n";
                } else {
                    return '';
                }
            }
            function validatePassword(password, check){
                document.getElementById("pw").className = "";                    
                document.getElementById("pwcheck").className = "";
                if(password == '' || check == ''){
                    document.getElementById("pw").className = "error";
                    return "enter and confirm password"
                }
                if(password != check){                    
                    document.getElementById("pw").className = "error";                    
                    document.getElementById("pwcheck").className = "error";
                    return "passwords do not match";
                } else {
                    return "";
                }
            }
            function confirm(frm){
                var reason = "";
                reason += validateName(frm.fname.value,frm.lname.value);
                reason += validateEmail(frm.email.value,frm.email_check.value);
                reason += validatePassword(frm.newpassword.value,frm.pass_check.value);

                if (reason != ''){
                    alert("Please correct the following errors:\n" + reason);
                } else{
                    return true;
                }
                return false;
            }
        </script>
    </body>
</html>