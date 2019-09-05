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
                  <a href="license.php?employeeid=<?php echo $_GET["employeeid"];?>" class="btn btn-success"><span class="fa fa-arrow-right"></span> Next (License)</a>
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
                    <h2>Educational Background</h2>
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
                            $up_educlevel = $_POST["up_educlevel"][$i];
                            $up_schoolname = strtoupper($_POST["up_schoolname"][$i]);
                            $up_degree = strtoupper($_POST["up_degree"][$i]);
                            if($_POST["up_periodfrom"][$i] == ''){
                              $up_periodfrom = null;
                            }else{
                              $up_periodfrom = $_POST["up_periodfrom"][$i];
                            }
                            if($_POST["up_periodto"][$i] == ''){
                              $up_periodto = null;
                            }else{
                              $up_periodto = $_POST["up_periodto"][$i];
                            }
                            $up_unitsearned = strtoupper($_POST["up_unitsearned"][$i]);
                            if($_POST["up_yrgraduate"][$i] == ''){
                              $up_yrgraduate = null;
                            }else{
                              $up_yrgraduate = $_POST["up_yrgraduate"][$i];
                            }

                            $up_honors = strtoupper($_POST["up_honors"][$i]);

                            $in = DB::run("UPDATE educbackground SET educlevel = ?, schoolname = ?, degree = ?, periodfrom = ?, periodto = ?, unitsearned = ?, yrgraduate = ?, honors = ? WHERE employeeid = ? AND itemno = ?", [$up_educlevel, $up_schoolname, $up_degree, $up_periodfrom, $up_periodto, $up_unitsearned, $up_yrgraduate, $up_honors, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

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
                        if (isset($_POST["schoolname"])) {
                          for ($i=0; $i < count($_POST["schoolname"]); $i++) {
                            $educlevel = $_POST["educlevel"][$i];
                            $schoolname = strtoupper($_POST["schoolname"][$i]);
                            $degree = strtoupper($_POST["degree"][$i]);
                            if($_POST["periodfrom"][$i] == ''){
                              $periodfrom = null;
                            }else{
                              $periodfrom = $_POST["periodfrom"][$i];
                            }
                            if($_POST["periodto"][$i] == ''){
                              $periodto = null;
                            }else{
                              $periodto = $_POST["periodto"][$i];
                            }
                            $unitsearned = strtoupper($_POST["unitsearned"][$i]);
                            if($_POST["yrgraduate"][$i] == ''){
                              $yrgraduate = null;
                            }else{
                              $yrgraduate = $_POST["yrgraduate"][$i];
                            }

                            $honors = strtoupper($_POST["honors"][$i]);

                            $in = DB::run("INSERT INTO educbackground(employeeid, educlevel, schoolname, degree, periodfrom, periodto, unitsearned, yrgraduate, honors) VALUES(?,?,?,?,?,?,?,?,?)", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $educlevel, $schoolname, $degree, $periodfrom, $periodto, $unitsearned, $yrgraduate, $honors]);

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
                          $del = DB::run("DELETE FROM educbackground WHERE employeeid = ? AND itemno = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
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
                          $ret = DB::run("SELECT * FROM educbackground WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                          $counter = 1;
                          while($row = $ret->fetch()){
                            $educlevel = $row["educlevel"];
                            $schoolname = $row["schoolname"];
                            $degree = $row["degree"];
                            $periodfrom = $row["periodfrom"];
                            $periodto = $row["periodto"];
                            $unitsearned = $row["unitsearned"];
                            $yrgraduate = $row["yrgraduate"];
                            $honors = $row["honors"];
                        ?>
                        <label>Row <?php echo "#" . $counter; ?>:</label>
                        <div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_itemno[]" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                            <select class="form-control" name="up_educlevel[]" data-toggle="tooltip" data-placement="top" title="Educational Level">
                              <option value=""> -- Select Education Level -- </option>
                              <option value="elementary" <?php echo $educlevel == "elementary" ? "selected" : ""; ?>>Elementary</option>
                              <option value="secondary" <?php echo $educlevel == "secondary" ? "selected" : ""; ?>>Secondary</option>
                              <option value="vocational" <?php echo $educlevel == "vocational" ? "selected" : ""; ?>>Vocational / Trade Course</option>
                              <option value="college" <?php echo $educlevel == "college" ? "selected" : ""; ?>>College</option>
                              <option value="graduate" <?php echo $educlevel == "graduate" ? "selected" : ""; ?>>Graduate Studies</option>
                            </select>
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_schoolname[]" placeholder="Name of School (Enter in full)" class="form-control" value="<?php echo $schoolname; ?>" data-toggle="tooltip" data-placement="top" title="Name of School">
                          </div>
                          <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_degree[]" placeholder="Basic Education/Degree/Course (Enter in full)" class="form-control" value="<?php echo $degree; ?>" data-toggle="tooltip" data-placement="top" title="Basic Education/Degree/Course">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="number" min="0" name="up_periodfrom[]" placeholder="Period of Attendance (From)" class="form-control" value="<?php echo $periodfrom; ?>" data-toggle="tooltip" data-placement="top" title="Period of Attendance (From)">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="number" min="0" name="up_periodto[]" placeholder="Period of Attendance (To)" class="form-control" value="<?php echo $periodto; ?>" data-toggle="tooltip" data-placement="top" title="Period of Attendance (To)">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_unitsearned[]" placeholder="Highest Level/Units Earned" class="form-control" value="<?php echo $unitsearned; ?>" data-toggle="tooltip" data-placement="top" title="Highest Level/Units Earned">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="number" min="0" name="up_yrgraduate[]" placeholder="Year Graduated" class="form-control" value="<?php echo $yrgraduate; ?>" data-toggle="tooltip" data-placement="top" title="Year Graduated">
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_honors[]" placeholder="Scholarship / Academic Honors Received" class="form-control" value="<?php echo $honors; ?>" data-toggle="tooltip" data-placement="top" title="Scholarship / Academic Honors Received">
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <a href="educational_background.php?<?php echo 'employeeid=' . (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]) . '&itemno=' . $row["itemno"]; ?>" class="btn btn-danger btn-xs"><span class="fa fa-times"></span> Delete</a>
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
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<select class=\"form-control\" name=\"educlevel[]\">" +
                              "<option value=\"\"> -- Select Education Level -- </option>" +
                              "<option value=\"elementary\">Elementary</option>" +
                              "<option value=\"secondary\">Secondary</option>" +
                              "<option value=\"vocational\">Vocational / Trade Course</option>" +
                              "<option value=\"college\">College</option>" +
                              "<option value=\"graduate\">Graduate Studies</option>" +
                            "</select>" +
                          "</div>" +
                          "<div class=\"col-md-4 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"schoolname[]\" placeholder=\"Name of School (Enter in full)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-5 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"degree[]\" placeholder=\"Basic Education/Degree/Course (Enter in full)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"number\" min=\"0\" name=\"periodfrom[]\" placeholder=\"Period of Attendance (From)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"number\" min=\"0\" name=\"periodto[]\" placeholder=\"Period of Attendance (To)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"unitsearned[]\" placeholder=\"Highest Level/Units Earned\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"number\" min=\"0\" name=\"yrgraduate[]\" placeholder=\"Year Graduated\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"honors[]\" placeholder=\"Scholarship / Academic Honors Received\" class=\"form-control\">" +
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
