<?php

session_start();

    if($_SERVER["REQUEST_METHOD"] === "POST"){
      
        try{
          include_once("includes/dbConnection.php");
            if (isset($_POST["creatAcount"])){ 
                $sql = "INSERT INTO `users`(`fullName`, `userName`, `email`, `password`) VALUES(?,?,?,?)";
                $Fullname = $_POST["Fullname"];
                $Username = $_POST["Username"];
                $Email    = $_POST["Email"]; 
                $Pass_word = password_hash($_POST["Password"], PASSWORD_DEFAULT);;
                $stmt=$conn->prepare($sql);
                $stmt->execute([$Fullname, $Username, $Email, $Pass_word ]);

            }elseif(isset($_POST["logIn"])){

              $Username = $_POST["logInUsername"];
              $Pass_word = $_POST["logInPassword"];
              $sql ="SELECT  `password` FROM `users` WHERE userName=? and active =1 ";
              $stmt=$conn->prepare($sql);
              $stmt->execute([$Username]);
             
                if ($stmt->rowCount() >0){
                  $result = $stmt->fetch();
                  $hash = $result["password"];
                  $verify = password_verify($Pass_word,$hash);

                    if ($verify){
                      $_SESSION["logged"]=true;
                      $_SESSION["id"]=$id;
                      $_SESSION["username"]=$Username;
                      header("Location:news.php");
                      die();
                    }
                    else{
                      echo "Password is incorrect, please try again ";
                    }
                }
                else{
                  echo"User Name not found";
                }
              
            }

          }catch(PDOException $e){
            echo "Connection failed" . $e->getMessage();
          }
      
      
    }
    

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>News Admin | Login/Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>" method ="POST">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" name="logInUsername"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name= "logInPassword"/>
              </div>
              <div>
              <button type="submit" class="btn btn-primary btn-lg" name="logIn"> Log in </button>
                <?php
                //<a class="btn btn-default submit" href="index.html">Log in</a>
                ?>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-newspaper-o"></i></i> News Admin</h1>
                  <p>©2016 All Rights Reserved. News Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
              

            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>" method ="POST">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Fullname" required="" name= "Fullname"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Username" required=""  name="Username"/>
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" name= "Email"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" name="Password" />
              </div>
              <div>
              <button type="submit" class="btn btn-primary btn-lg" name="creatAcount"> Submit </button>
               <?php
               // <a class="btn btn-default submit" href="index.html">Submit</a>
               ?>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-newspaper-o"></i></i> News Admin</h1>
                  <p>©2016 All Rights Reserved. News Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
