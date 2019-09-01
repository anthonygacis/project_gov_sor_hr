<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }

  if(isset($_GET["employeeid"])){
    if($_GET["employeeid"] != ""){
      $employeeid = $_GET["employeeid"];

      // get full name
      $r = DB::run("SELECT * FROM employee WHERE employeeid = ?", [$employeeid]);
      if($row = $r->fetch()){
        $fullname = $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"];
      }
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
                <h3>Update Information <?php echo (isset($fullname) ? "(" . $fullname . ")" : ""); ?></h3>
              </div>
              <?php
                if(isset($_GET["employeeid"]) && $_SESSION["user_type"] == "admin"){
              ?>
              <div class="title_right">
                <div class="col-md-8 col-sm-8 col-xs-12 form-group pull-right">
                  <a href="employee.php" class="btn btn-info"><span class="fa fa-arrow-left"></span> Go Back (Employee)</a>
                </div>
              </div>
              <?php
                }
              ?>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Learning and Development (L&amp;D) Interventions / Training Programs Attended</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submit"])){

                        // updating item
                        $mod = false;
                        if (isset($_POST["up_itemno"])) {
                          for ($i=0; $i < count($_POST["up_itemno"]); $i++) {
                            $up_itemno = $_POST["up_itemno"][$i];
                            $up_inclusivedate_from = $_POST["up_inclusivedate_from"][$i];
                            $up_inclusivedate_to = $_POST["up_inclusivedate_to"][$i];
                            $up_training_title = strtoupper($_POST["up_training_title"][$i]);
                            $up_type_of_ld = strtoupper($_POST["up_type_of_ld"][$i]);
                            $up_no_of_hours = $_POST["up_no_of_hours"][$i];
                            $up_sponsored_by = strtoupper($_POST["up_sponsored_by"][$i]);

                            $in = DB::run("UPDATE training_prog SET inclusivedate_from = ?, inclusivedate_to = ?, training_title = ?, type_of_ld = ?, no_of_hours = ?, sponsored_by = ? WHERE employeeid = ? AND itemno = ?", [$up_inclusivedate_from, $up_inclusivedate_to, $up_training_title, $up_type_of_ld, $up_no_of_hours, $up_sponsored_by, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

                            if($in->rowCount() > 0){
                              $mod = true;
                            }
                          }
                        }

                        if($mod){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been modified
                    </div>
                    <?php
                        }

                        // adding item
                        $add = false;
                        if (isset($_POST["training_title"])) {
                          for ($i=0; $i < count($_POST["training_title"]); $i++) {
                            $inclusivedate_from = $_POST["inclusivedate_from"][$i];
                            $inclusivedate_to = $_POST["inclusivedate_to"][$i];
                            $training_title = strtoupper($_POST["training_title"][$i]);
                            $type_of_ld = strtoupper($_POST["type_of_ld"][$i]);
                            $no_of_hours = $_POST["no_of_hours"][$i];
                            $sponsored_by = strtoupper($_POST["sponsored_by"][$i]);

                            $in = DB::run("INSERT INTO training_prog(employeeid, training_title, inclusivedate_from, inclusivedate_to, no_of_hours, type_of_ld, sponsored_by) VALUES(?, ?, ?, ?, ?, ?, ?)", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $training_title, $inclusivedate_from, $inclusivedate_to, $no_of_hours, $type_of_ld, $sponsored_by]);

                            if($in->rowCount() > 0){
                              $add = true;
                            }
                          }
                        }

                        if($add){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been updated
                    </div>
                    <?php
                        }
                      }
                    ?>

                    <?php
                      if(isset($_GET["itemno"])){
                        if($_GET["itemno"] != ""){
                          // Delete operation
                          $del = DB::run("DELETE FROM training_prog WHERE employeeid = ? AND itemno = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
                          if($del->rowCount() > 0){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been deleted
                    </div>
                    <?php
                          }
                        }else{
                          header("Location: educational_background.php");
                        }
                      }
                    ?>
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <div class="row">
                        <?php
                          $ret = DB::run("SELECT * FROM training_prog WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                          $counter = 1;
                          while($row = $ret->fetch()){
                            $inclusivedate_from = $row["inclusivedate_from"];
                            $inclusivedate_to = $row["inclusivedate_to"];
                            $training_title = $row["training_title"];
                            $type_of_ld = $row["type_of_ld"];
                            $no_of_hours = $row["no_of_hours"];
                            $sponsored_by = $row["sponsored_by"];
                        ?>
                        <label>Row <?php echo "#" . $counter; ?>:</label>
                        <div class="row">
                          <input type="text" name="up_itemno[]" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                            <label>&nbsp;</label>
                            <input type="text" name="up_training_title[]" data-toggle="tooltip" data-placement="top" title="Title of Learning and Development Interventions / Training Programs" class="form-control" value="<?php echo $row["training_title"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>From:</label>
                            <input type="date" name="up_inclusivedate_from[]" data-toggle="tooltip" data-placement="top" title="Inclusive Dates (From)" class="form-control" value="<?php echo $row["inclusivedate_from"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>To:</label>
                            <input type="date" name="up_inclusivedate_to[]" data-toggle="tooltip" data-placement="top" title="Inclusive Dates (To)" class="form-control" value="<?php echo $row["inclusivedate_to"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>&nbsp;</label>
                            <input type="number" min="0" step="0.01" name="up_no_of_hours[]" data-toggle="tooltip" data-placement="top" title="No. of Hours" class="form-control" value="<?php echo $row["no_of_hours"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_type_of_ld[]" data-toggle="tooltip" data-placement="top" title="Type of LD" class="form-control" value="<?php echo $row["type_of_ld"]; ?>">
                          </div>
                          <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_sponsored_by[]" data-toggle="tooltip" data-placement="top" title="Conducted / Sponsored by (Write in full)" class="form-control" value="<?php echo $row["sponsored_by"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <a href="training_programs.php?<?php echo 'employeeid=' . (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]) . '&itemno=' . $row["itemno"]; ?>" class="btn btn-danger"><span class="fa fa-times"></span> Delete</a>
                          </div>
                        </div>
                        <?php
                            $counter++;
                          }
                        ?>
                        &nbsp;
                        <div id="item_container">
                        </div>
                        <!-- Commands -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <br/>
                          <input type="button" id="add_item" value="Add Item" class="btn btn-info btn-sm">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <br/>
                          <input type="submit" name="submit" value="Save Changes" class="btn btn-success">
                        </div>
                      </div>
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
    <script src="js/custom/global_set.js"></script>


    <script>
      function addItem(counter){
        var label = "<label class=\"irow" + counter + " labelText\">Item #" + counter + ":</label>";
        var template = "<div class=\"irow" + counter + " row\">" +
                          "<div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">" +
                            "<label>&nbsp;</label>" +
                            "<input type=\"text\" name=\"training_title[]\" placeholder=\"Title of Learning and Development Interventions / Training Programs\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<label>From:</label>" +
                            "<input type=\"date\" name=\"inclusivedate_from[]\" title=\"Inclusive Dates (From)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<label>To:</label>" +
                            "<input type=\"date\" name=\"inclusivedate_to[]\" title=\"Inclusive Dates (To)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<label>&nbsp;</label>" +
                            "<input type=\"number\" min=\"0\" step=\"0.01\" name=\"no_of_hours[]\" placeholder=\"No. of Hours\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"type_of_ld[]\" placeholder=\"Type of LD\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-8 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"sponsored_by[]\" placeholder=\"Conducted / Sponsored by (Write in full)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-4 col-sm-12 col-xs-12 form-group\">" +
                            "<button type=\"button\" class=\"btn btn-danger\" onclick=\"removeRow('.irow" + counter + "')\"><span class=\"fa fa-close\"></span></button>" +
                          "</div>" +
                        "</div>";
        $("#item_container").append(label + template);
      }

      var counter = 1;
      $("#add_item").on('click', function(){
        addItem(counter);
        counter++;
        resCount();
      });
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
