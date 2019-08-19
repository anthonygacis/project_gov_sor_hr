<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }


  if(isset($_GET["employeeid"])){
    if($_GET["employeeid"] != ""){
      $employeeid = $_GET["employeeid"];

      $ret = DB::run("SELECT * FROM employee WHERE employeeid = ?", [$employeeid]);
      if($row = $ret->fetch()){
        $fullname = $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"];
      }
    }else{
      header("Location: index.php");
    }
  }else{
    header("Location: index.php");
  }


  if(isset($_POST["update_appointment"])){
    $appointmenttno = $_POST["appointmenttno"];
    $apptdate = $_POST["apptdate"];
    $rankid = $_POST["rankid"];
    $empstatusid = $_POST["empstatusid"];
    $salarygradeid = $_POST["salarygradeid"];

    $up = DB::run("UPDATE appointment SET rankid = ?, empstatusid = ?, salarygradeid = ?, apptdate = ? WHERE employeeid = ? AND appointmenttno = ?", [$rankid, $empstatusid, $salarygradeid, $apptdate, $employeeid, $appointmenttno]);

    if($up->rowCount() > 0){
      $modify_status["update"] = true;
    }else{
      $modify_status["update"] = false;
    }
  }
  if(isset($_POST["remove_appointment"])){
    $appointmenttno = $_POST["appointmenttno"];

    $del = DB::run("DELETE FROM appointment WHERE employeeid = ? AND appointmenttno = ?", [$employeeid, $appointmenttno]);

    if($del->rowCount() > 0){
      $modify_status["delete"] = true;
    }else{
      $modify_status["delete"] = false;
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
                <h3>Employee Name: <?php echo $fullname; ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="alert alert-info alert-dismissible fade in" role="alert">
              <strong>Note!</strong> Kindly click the row if you want to update the record
            </div>

            <?php
              if(isset($modify_status)){
            ?>
            <div class="alert alert-success alert-dismissible fade in" role="alert">
              <strong>Success!</strong> Data has been <?php echo isset($modify_status["update"]) ? "updated" : "deleted"; ?>
            </div>
            <?php
              }
            ?>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Appointments</h2>
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
                          <th>Appointment Date</th>
                          <th>Rank</th>
                          <th>Employee Status</th>
                          <th>Salary Grade</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          // retrieve appointment
                          $appt = DB::run("SELECT * FROM appointment a LEFT JOIN rank r ON a.rankid = r.rankid LEFT JOIN empstatus e ON a.empstatusid = e.empstatusid LEFT JOIN salarygrade s ON a.salarygradeid = s.salaryid WHERE employeeid = ? ORDER BY a.apptdate DESC", [$employeeid]);

                          $currentAppt = $currRank = $currEmpStatus = $currEmpType = "";
                          while($arow = $appt->fetch()){
                            $currentAppt = $arow["apptdate"];
                            $currRank = $arow["ranktitle"];
                            $currEmpStatus = $arow["statustitle"];
                            $currSalaryTitle = $arow["salarytitle"];

                        ?>
                        <tr onclick="<?php echo "showInfo($arow[appointmenttno], '$arow[apptdate]', '$arow[rankid]', '$arow[empstatusid]', '$arow[salarygradeid]');"?>" style="cursor: pointer;">
                          <td><?php echo $currentAppt; ?></td>
                          <td><?php echo $currRank; ?></td>
                          <td><?php echo $currEmpStatus; ?></td>
                          <td><?php echo $currSalaryTitle; ?></td>
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
            <div class="row" id="row_update" style="display: none;">
              <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Set Appointment</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <input type="text" name="appointmenttno" class="form-control" readonly id="appointmenttno" style="display: none;">
                      <label>Appointment Date: </label>
                      <input type="date" name="apptdate" class="form-control" id="apptdate">
                      <br/>
                      <label>Select Rank: </label>
                      <select name="rankid" class="form-control" required id="rankid">
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
                      <select name="empstatusid" class="form-control" required id="empstatusid">
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
                      <select name="salarygradeid" class="form-control" required id="salarygradeid">
                        <option value=""> -- Select -- </option>
                        <?php
                          $emp = DB::run("SELECT * FROM salarygrade ORDER BY salarytitle ASC");
                          while ($row = $emp->fetch()) {
                        ?>
                          <option value="<?php echo $row["salaryid"]; ?>"> <?php echo $row["salarytitle"] . "\t( Php " . number_format($row["amount"], 2) . ")"; ?> </option>
                        <?php
                          }
                        ?>
                      </select>
                      <br/>
                      <input type="submit" name="update_appointment" value="Save Changes" class="btn btn-success">
                      <input type="submit" name="remove_appointment" value="Remove" class="btn btn-danger">
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
      function showInfo(appointmenttno, apptdate, rankid, empstatusid, salarygradeid, emptype, campusid) {
        $('#row_update').show();

        $('#appointmenttno').val(appointmenttno);
        $('#apptdate').val(apptdate);
        $('#rankid').val(rankid);
        $('#empstatusid').val(empstatusid);
        $('#salarygradeid').val(salarygradeid);
        $('#emptype').val(emptype);
        $('#campusid').val(campusid);
      }

      $("#datatable").dataTable({
        "order" : [0, "desc"]
      });
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
