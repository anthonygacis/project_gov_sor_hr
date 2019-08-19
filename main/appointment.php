<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }

  // for add
  $add_status = false;
  if(isset($_POST["submit"])){
    $apptdate = $_POST["apptdate"];
    $employeeid = $_POST["employeeid"];
    $rankid = $_POST["rankid"];
    $empstatusid = $_POST["empstatusid"];
    $salarygradeid  = $_POST["salarygradeid"];


    $add = DB::run("INSERT INTO appointment(employeeid, rankid, empstatusid, salarygradeid, apptdate) VALUES(?,?,?,?,?)", [$employeeid, $rankid, $empstatusid, $salarygradeid, $apptdate]);

    if($add->rowCount() > 0){
      $add_status = true;
    }
  }

  if(isset($_POST["update_grade"])){ // For update
    $salaryid = $_POST["salaryid"];
    $salarytitle = strtoupper($_POST["salarytitle"]);
    $amount = $_POST["amount"];

    $update = DB::run("UPDATE salarygrade SET salarytitle = ?, amount = ? WHERE salaryid = ?", [$salarytitle, $amount, $salaryid]);

    if($update->rowCount() > 0){
      $modify_success["update"] = true;
    }else{
      $modify_success["update"] = false;
    }
  }
  if(isset($_POST["remove_grade"])){ // For delete
    $salaryid = $_POST["salaryid"];

    $update = DB::run("DELETE FROM salarygrade WHERE salaryid = ?", [$salaryid]);

    if($update->rowCount() > 0){
      $modify_success["delete"] = true;
    }else{
      $modify_success["delete"] = false;
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

    <title>Employee Management System | Welcome "<?php echo $_SESSION["username"];?>"</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">


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
                <h3>Settings</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Employees</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Employee Name</th>
                          <th>Current Appointment</th>
                          <th>Commands</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $retrieve = DB::run("SELECT * FROM employee");
                          while ($row = $retrieve->fetch()) {
                            $display_name = $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"];
                            // retrieve appointment
                            $appt = DB::run("SELECT * FROM appointment a LEFT JOIN rank r ON a.rankid = r.rankid LEFT JOIN empstatus e ON a.empstatusid = e.empstatusid WHERE a.employeeid = ? ORDER BY a.apptdate DESC", [$row["employeeid"]]);

                            $currentAppt = $currRank = $currEmpStatus = "";
                            if($arow = $appt->fetch()){
                              $currentAppt = $arow["apptdate"];
                              $currRank = ($arow["ranktitle"] == null ? "Update Rank" : $arow["ranktitle"]);
                              $currEmpStatus = ($arow["statustitle"] == null ? "Update Status" : $arow["statustitle"]);
                            }
                        ?>
                        <tr>
                          <td><?php echo $display_name; ?></td>
                          <td><?php echo $currentAppt == "" ? ("") : ($currRank . " - " . $currEmpStatus . " - (" . $currentAppt . ")") ; ?></td>
                          <td><a href="view_appointment.php?employeeid=<?php echo $row['employeeid']; ?>" class="btn btn-success btn-xs"><span class="fa fa-edit"></span> Edit</a></td>
                        </tr>
                        <?php
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="row_update">
              <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Set Appointment</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if($add_status){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been added
                    </div>
                    <?php
                      }
                    ?>

                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                      <label>Appointment Date: </label>
                      <input type="date" name="apptdate" class="form-control">
                      <br/>
                      <label>Select Employee: </label>
                      <select name="employeeid" class="form-control" required>
                        <option value=""> -- Select -- </option>
                        <?php
                          $emp = DB::run("SELECT * FROM employee ORDER BY lname ASC");
                          while ($row = $emp->fetch()) {
                        ?>
                          <option value="<?php echo $row["employeeid"]; ?>"> <?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"]; ?> </option>
                        <?php
                          }
                        ?>
                      </select>
                      <br/>
                      <label>Select Rank: </label>
                      <select name="rankid" class="form-control" required>
                        <option value=""> -- Select -- </option>
                        <?php
                          $emp = DB::run("SELECT * FROM rank ORDER BY ranktitle ASC");
                          while ($row = $emp->fetch()) {
                        ?>
                          <option value="<?php echo $row["rankid"]; ?>"> <?php echo $row["ranktitle"]; ?> </option>
                        <?php
                          }
                        ?>
                      </select>
                      <br/>
                      <label>Select Employee Status: </label>
                      <select name="empstatusid" class="form-control" required>
                        <option value=""> -- Select -- </option>
                        <?php
                          $emp = DB::run("SELECT * FROM empstatus ORDER BY statustitle ASC");
                          while ($row = $emp->fetch()) {
                        ?>
                          <option value="<?php echo $row["empstatusid"]; ?>"> <?php echo $row["statustitle"]; ?> </option>
                        <?php
                          }
                        ?>
                      </select>
                      <br/>
                      <label>Select Salary Grade: </label>
                      <select name="salarygradeid" class="form-control" required>
                        <option value=""> -- Select -- </option>
                        <?php
                          $emp = DB::run("SELECT * FROM salarygrade ORDER BY salarytitle ASC");
                          while ($row = $emp->fetch()) {
                        ?>
                          <option value="<?php echo $row["salaryid"]; ?>"> <?php echo $row["salarytitle"] . "\t(Php " . number_format($row["amount"], 2) . ")"; ?> </option>
                        <?php
                          }
                        ?>
                      </select>
                      <br/>
                      <input type="submit" name="submit" value="Add Appointment" class="btn btn-success">
                    </form>
                  </div>
                </div>
              </div>
            </div>
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
    <!-- Datatables -->
    <script src="../vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.js"></script>


    <script>
      function showInfo(salaryid, salarytitle, amount) {
        $('#row_update').show();

        $('#salaryid').val(salaryid);
        $('#salarytitle').val(salarytitle);
        $('#amount').val(amount);
      }
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
