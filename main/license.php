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
                <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right">
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
                    <h2>Licenses</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submit"])){

                        $add = false;
                        // updating item
                        if (isset($_POST["up_itemno"])) {
                          for ($i=0; $i < count($_POST["up_itemno"]); $i++) {
                            $up_itemno = $_POST["up_itemno"][$i];
                            $up_licensename = strtoupper($_POST["up_licensename"][$i]);
                            $up_rating = $_POST["up_rating"][$i];
                            $up_examdate = $_POST["up_examdate"][$i];
                            $up_place = strtoupper($_POST["up_place"][$i]);
                            $up_licenseno = $_POST["up_licenseno"][$i];
                            $up_validdate = $_POST["up_validdate"][$i];

                            $in = DB::run("UPDATE license SET licensename = ?, rating = ?, examdate = ?, place = ?, licenseno = ?, validdate = ? WHERE employeeid = ? AND itemno = ?", [$up_licensename, $up_rating, $up_examdate, $up_place, $up_licenseno, $up_validdate, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

                            if($in->rowCount() > 0){
                              $add = true;
                            }

                          }
                        }

                        // adding item
                        if (isset($_POST["licensename"])) {
                          for ($i=0; $i < count($_POST["licensename"]); $i++) {
                            $licensename = strtoupper($_POST["licensename"][$i]);
                            $rating = $_POST["rating"][$i];
                            $examdate = $_POST["examdate"][$i];
                            $place = strtoupper($_POST["place"][$i]);
                            $licenseno = $_POST["licenseno"][$i];
                            $validdate = $_POST["validdate"][$i];

                            $in = DB::run("INSERT INTO license(employeeid, licensename, rating, examdate, place, licenseno, validdate) VALUES(?,?,?,?,?,?,?)", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $licensename, $rating, $examdate, $place, $licenseno, $validdate]);

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
                          $del = DB::run("DELETE FROM license WHERE employeeid = ? AND itemno = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
                          if($del->rowCount() > 0){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been deleted
                    </div>
                    <?php
                          }
                        }else{
                          header("Location: license.php");
                        }
                      }
                    ?>
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <div class="row">
                        <?php
                          $ret = DB::run("SELECT * FROM license WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                          $counter = 1;
                          while($row = $ret->fetch()){
                            $licensename = $row["licensename"];
                            $rating = $row["rating"];
                            $examdate = $row["examdate"];
                            $place = $row["place"];
                            $licenseno = $row["licenseno"];
                            $validdate = $row["validdate"];
                        ?>
                        <label>Row <?php echo "#" . $counter; ?>:</label>
                        <div>
                          <input type="text" name="up_itemno[]" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_licensename[]" placeholder="License' Name" class="form-control" value="<?php echo $licensename; ?>" data-toggle="tooltip" data-placement="top" title="License Name">
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_rating[]" placeholder="Rating" class="form-control" value="<?php echo $rating; ?>" data-toggle="tooltip" data-placement="top" title="Rating">
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="date" name="up_examdate[]" placeholder="Exam Date" class="form-control" value="<?php echo $examdate; ?>" data-toggle="tooltip" data-placement="top" title="Exam Date">
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_place[]" placeholder="Place" class="form-control" value="<?php echo $place; ?>" data-toggle="tooltip" data-placement="top" title="Place">
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_licenseno[]" placeholder="License No." class="form-control" value="<?php echo $licenseno; ?>" data-toggle="tooltip" data-placement="top" title="License No.">
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="date" name="up_validdate[]" placeholder="Valid Date" class="form-control" value="<?php echo $validdate; ?>" data-toggle="tooltip" data-placement="top" title="Valid Date">
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <a href="license.php?<?php echo 'employeeid=' . (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]) . '&itemno=' . $row["itemno"]; ?>" class="btn btn-danger btn-xs"><span class="fa fa-times"></span> Delete</a>
                          </div>
                        </div>
                        <?php
                            $counter++;
                          }
                        ?>
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
                          "<div class=\"col-md-9 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"licensename[]\" placeholder=\"License' Name\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"rating[]\" placeholder=\"Rating\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2\ col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"date\" name=\"examdate[]\" placeholder=\"Exam Date\" class=\"form-control\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Examination Date\">" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"place[]\" placeholder=\"Place\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"licenseno[]\" placeholder=\"License No.\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"date\" name=\"validdate[]\" placeholder=\"Valid Date\" class=\"form-control\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Valid Date\">" +
                          "</div>" +
                          "<div class=\"col-md-1 col-sm-12 col-xs-12 form-group\">" +
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
