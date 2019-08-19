<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
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
                <h3>Data Entry</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="alert alert-info alert-dismissible fade in" role="alert">
              <strong>Note!</strong> Kindly click the row for the update
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Salary Grade</h2>
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
                    <?php
                      if(isset($_POST["submit"])){
                        $salarytitle = strtoupper($_POST["salarytitle"]);
                        $amount = $_POST["amount"];

                        $in = DB::run("INSERT INTO salarygrade(salarytitle, amount) VALUES(?,?)", [$salarytitle, $amount]);
                        if($in->rowCount() > 0){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Success!</strong> Data has been added
                    </div>
                    <?php
                        }else{
                    ?>
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Failed!</strong> Something's wrong
                    </div>
                    <?php
                        }
                      }
                    ?>
                    <?php
                      if(isset($modify_success)){ // TO DO: modify success condition here
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Success!</strong> Data has been <?php echo (isset($modify_success["update"]) ? "updated" : "deleted"); ?>
                    </div>
                    <?php
                      }
                    ?>
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Salary Grade Title</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $retrieve = DB::run("SELECT * FROM salarygrade");
                            while ($row = $retrieve->fetch()) {
                          ?>
                          <tr onclick="<?php echo "showInfo($row[salaryid], '$row[salarytitle]', '$row[amount]');"?>" style="cursor: pointer;">
                            <td><?php echo $row["salarytitle"]; ?></td>
                            <td><?php echo $row["amount"]; ?></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                      <div>
                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target=".modal_salary"><span class="fa fa-plus"></span> Add Salary Grade</button>

                        <div class="modal fade modal_salary" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                  <h4 class="modal-title" id="myModalLabel">Add Employee</h4>
                                </div>
                                <div class="modal-body">
                                  <label>Salary Grade Title: </label>
                                  <input type="text" maxlength="6" class="form-control" name="salarytitle" placeholder="Enter your text ... (Max. 6 characters)" required>
                                  <br/>
                                  <label>Amount: </label>
                                  <input type="number" min="0" class="form-control" name="amount" placeholder="Enter your text ..." required>
                                  <br/>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>

                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" id="row_update" style="display: none;">
              <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Salary Grade Update</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                      <input type="text" name="salaryid" id="salaryid" style="display: none;">
                      <label>Salary Grade Title: </label>
                      <input class="form-control" type="text" maxlength="6" name="salarytitle" id="salarytitle" required>
                      <br/>
                      <label>Amount: </label>
                      <input class="form-control" type="number" min="0" name="amount" id="amount" required>
                      <br/>
                      <input type="submit" name="update_grade" value="Save Changes" class="btn btn-success">
                      <input type="submit" name="remove_grade" value="Remove" class="btn btn-danger">
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

      $('#datatable2').dataTable();
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
