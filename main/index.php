<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
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

    <title>Employee Management System | Welcome "<?php echo $_SESSION["username"];?>"</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <?php
            require_once("modules/navigation.php");
          ?>
        </div>

        <?php
          require_once("modules/header.php");
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Search Employee</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="GET">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Search it here... </label>
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input style="height: 60px; font-size: 20pt;" type="text" name="query" class="form-control" placeholder="Enter your Text ..." required>
                                <span class="input-group-btn">
                                    <button style="height: 60px;" type="submit" class="btn btn-primary"><span class="fa fa-search"></span> Search</button>
                                </span>
                            </div>
                        </div>
                      </div>
                </form>
            </div>
            <?php
                if(isset($_GET["query"])){
                    //search the database
                    $str_query = $_GET["query"];
                    $var_query = "%" . $str_query . "%";
                    $result = DB::run("SELECT * FROM employee WHERE lname LIKE ? OR fname LIKE ? OR midname LIKE ? ORDER BY lname DESC", [$var_query,$var_query,$var_query]);
            ?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Search Result/s: <?php echo "\"" . $_GET["query"] . "\""?></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <ul class="list-unstyled timeline">
                      <?php
                            while($row = $result->fetch()){
                                // join appointment
                              $app = DB::run("SELECT * FROM appointment a JOIN rank r ON a.rankid = r.rankid JOIN empstatus e ON a.empstatusid = e.empstatusid JOIN salarygrade s ON a.salarygradeid = s.salaryid WHERE employeeid = ? ORDER BY apptdate DESC", [$row["employeeid"]]);


                              $output = [];
                              while($arow = $app->fetch()){
                                array_push($output, [$arow["emptype"], $arow["ranktitle"], $arow["statustitle"], $arow["salarytitle"], $arow["apptdate"]]);
                              }
                        ?>
                        <li>
                          <div class="block">
                            <div class="tags">
                              <a class="tag">
                                <span>
                                  <?php
                                    // if(count($output) > 0){
                                    //   echo ($output[0][0] == "T" ? "TEACHING" : "NON-TEACHING");
                                    // }
                                  ?>
                                </span>
                              </a>
                            </div>
                            <div class="block_content">
                              <h2 class="title">
                                  <a href="<?php echo "view_employee.php?employeeid=$row[employeeid]";?>"><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"];?></a>
                              </h2>
                              <div class="byline">
                                <a>
                                  Current Rank:
                                  <?php
                                    if(count($output) > 0){
                                      echo $output[0][1];
                                    }
                                  ?>,
                                  Appointment Date:
                                  <?php
                                    if(count($output) > 0){
                                      echo $output[0][4];
                                    }
                                  ?>
                                </a>
                              </div>
                              <p class="excerpt">
                                <table class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th>Employee Status</th>
                                      <th>Salary Grade</th>
                                      <th>Appointment Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      for ($i=0; $i < count($output); $i++) {
                                    ?>
                                    <tr>
                                      <td><?php echo $output[$i][2]; ?></td>
                                      <td><?php echo $output[$i][3]; ?></td>
                                      <td><?php echo $output[$i][4]; ?></td>
                                    </tr>
                                    <?php
                                      }
                                    ?>

                                  </tbody>
                                </table>
                              </p>
                            </div>
                          </div>
                        </li>
                        <?php
                            }
                        ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <?php
                }
            ?>
          </div>
        </div>
        <!-- /page content -->

        <?php
          require_once("modules/footer.php");
        ?>
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
