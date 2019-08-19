<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }

  if(isset($_POST["update_rank"])){ // For rank update
    $rankid = $_POST["rankid"];
    $ranktitle = strtoupper($_POST["ranktitle"]);

    $update = DB::run("UPDATE rank SET ranktitle = ? WHERE rankid = ?", [$ranktitle, $rankid]);

    if($update->rowCount() > 0){
      $modify_success_rank["updateRank"] = true;
    }else{
      $modify_success_rank["updateRank"] = false;
    }
  }
  if(isset($_POST["update_emp_status"])){ // For employee status update
    $empstatusid = $_POST["empstatusid"];
    $statustitle = strtoupper($_POST["statustitle"]);

    $update = DB::run("UPDATE empstatus SET statustitle = ? WHERE empstatusid = ?", [$statustitle, $empstatusid]);

    if($update->rowCount() > 0){
      $modify_success_emp_status["update_emp_status"] = true;
    }else{
      $modify_success_emp_status["update_emp_status"] = false;
    }
  }

  // ======================= TO DO: Rank and Employee Status Deletion =======================
  if(isset($_POST["remove_rank"])){ // For delete
    $rankid = $_POST["rankid"];

    $delete = DB::run("DELETE FROM rank WHERE rankid = ?", [$rankid]);

    if($delete->rowCount() > 0){
      $modify_success_rank["deleteRank"] = true;
    }else{
      $modify_success_rank["deleteRank"] = false;
    }
  }
  if(isset($_POST["remove_emp_status"])){ // For delete
    $empstatusid = $_POST["empstatusid"];

    $delete = DB::run("DELETE FROM empstatus WHERE empstatusid = ?", [$empstatusid]);

    if($delete->rowCount() > 0){
      $modify_success_emp_status["delete_emp_status"] = true;
    }else{
      $modify_success_emp_status["delete_emp_status"] = false;
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

              <?php
                if(strpos($priviledges, 'rank') !== false){
              ?>
              <!-- For Rank -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Rank</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submitRank"])){
                        $ranktitle = strtoupper($_POST["ranktitle"]);

                        $in = DB::run("INSERT INTO rank(ranktitle) VALUES(?)", [$ranktitle]);
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
                      if(isset($modify_success_rank)){ // TO DO: modify success condition here
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Success!</strong> Data has been <?php echo (isset($modify_success_rank["updateRank"]) ? "updated" : "deleted"); ?>
                    </div>
                    <?php
                      }
                    ?>
                     <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Rank Title</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $retrieve = DB::run("SELECT * FROM rank");
                            while ($row = $retrieve->fetch()) {
                          ?>
                          <tr onclick="<?php echo "showInfoRank($row[rankid], '$row[ranktitle]');"?>" style="cursor: pointer;">
                            <td><?php echo $row["ranktitle"]; ?></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                      <div>
                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm"><span class="fa fa-plus"></span> Add Rank</button>

                        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                  <h4 class="modal-title" id="myModalLabel">Add Rank</h4>
                                </div>
                                <div class="modal-body">
                                  <label>Rank Title: </label>
                                  <input type="text" class="form-control" name="ranktitle" placeholder="Enter your text ..." required>
                                  <br/>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="submitRank" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>

                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <?php
                }
              ?>

              <?php
                if(strpos($priviledges, 'emp_status') !== false){
              ?>
              <!-- For Employee Status -->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>List of Employee Status</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submitEmpStatus"])){
                        $statustitle = strtoupper($_POST["statustitle"]);

                        $in = DB::run("INSERT INTO empstatus(statustitle) VALUES(?)", [$statustitle]);
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
                      if(isset($modify_success_emp_status)){ // TO DO: modify success condition here
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                      </button>
                      <strong>Success!</strong> Data has been <?php echo (isset($modify_success_emp_status["update_emp_status"]) ? "updated" : "deleted"); ?>
                    </div>
                    <?php
                      }
                    ?>
                     <table id="datatableRank" class="table table-striped table-bordered">
                        <thead>
                          <tr>
                            <th>Status Title</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $retrieve = DB::run("SELECT * FROM empstatus");
                            while ($row = $retrieve->fetch()) {
                          ?>
                          <tr onclick="<?php echo "showInfoEmpStatus($row[empstatusid], '$row[statustitle]');"?>" style="cursor: pointer;">
                            <td><?php echo $row["statustitle"]; ?></td>
                          </tr>
                          <?php
                            }
                          ?>
                        </tbody>
                      </table>
                      <div>
                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target=".bs-emp-modal-sm"><span class="fa fa-plus"></span> Add Employee Status</button>

                        <div class="modal fade bs-emp-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-sm">
                            <div class="modal-content">

                              <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                                  </button>
                                  <h4 class="modal-title" id="myModalLabel">Add Employee Status</h4>
                                </div>
                                <div class="modal-body">
                                  <label>Status Title: </label>
                                  <input type="text" class="form-control" name="statustitle" placeholder="Enter your text ..." required>
                                  <br/>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" name="submitEmpStatus" class="btn btn-primary">Save changes</button>
                                </div>
                              </form>

                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <?php
                }
              ?>


            </div>
            <div class="row">
              <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12" id="row_rank" style="display: none;">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Rank Update</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                      <input type="text" name="rankid" id="rankid" style="display: none;">
                      <label>Rank Title: </label>
                      <input class="form-control" type="text" name="ranktitle" id="ranktitle" required>
                      <br/>
                      <input type="submit" name="update_rank" value="Save Changes" class="btn btn-success">
                      <input type="submit" name="remove_rank" value="Remove" class="btn btn-danger">
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-md-offset-3 col-sm-6 col-xs-12" id="row_emp_status" style="display: none;">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Employee Status Update</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                      <input type="text" name="empstatusid" id="empstatusid" style="display: none;">
                      <label>Status Title: </label>
                      <input class="form-control" type="text" name="statustitle" id="statustitle" required>
                      <br/>
                      <input type="submit" name="update_emp_status" value="Save Changes" class="btn btn-success">
                      <input type="submit" name="remove_emp_status" value="Remove" class="btn btn-danger">
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
      function showInfoRank(rankid, ranktitle) {
        $('#row_rank').show();
        $('#row_emp_status').hide();

        $('#rankid').val(rankid);
        $('#ranktitle').val(ranktitle);
      }
      function showInfoEmpStatus(empstatusid, statustitle) {
        $('#row_emp_status').show();
        $('#row_rank').hide();

        $('#empstatusid').val(empstatusid);
        $('#statustitle').val(statustitle);
      }

      $("#datatableRank").dataTable(); // initializing the datatable
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
