<?php
  include "connection/connection.php";
  session_start();

  if(isset($_SESSION["username"])){
    header("Location: index.php");
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

    <title>Employee Management System | Government of Sorsogon</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
              <h1>Welcome User</h1>
              <?php
                if(isset($_POST["submit"])){
                  $username = $_POST["username"];
                  $password = md5($_POST["password"]);

                  $test = DB::run("SELECT * FROM user_accounts WHERE username = ? AND password = ?", [$username, $password]);
                  if($row = $test->fetch()){
                    $_SESSION["uid"] = $row["uid"];
                    $_SESSION["user_type"] = $row["user_type"];
                    $_SESSION["username"] = $row["username"];
                    $_SESSION["priviledges"] = $row["priviledges"];

                    header("Location: index.php");
                  }else{
              ?>
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                Account doesn't exist!
              </div>
              <?php
                  }
                }
              ?>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default" href="index.html" name="submit">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-users"></i> GOV SOR-EMS 2019</h1>
                  <p>©2019 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
