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
                if(isset($_GET["employeeid"]) ){
              ?>
              <div class="title_right">
                <div class="col-md-8 col-sm-8 col-xs-12 form-group pull-right">
                  <a href="employee.php" class="btn btn-info"><span class="fa fa-arrow-left"></span> Go Back (Employee)</a>
                  <a href="emp_ques.php?employeeid=<?php echo $_GET["employeeid"];?>" class="btn btn-success"><span class="fa fa-arrow-right"></span> Next (Yes-No Questions)</a>
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
                    <h2>Other Information</h2>
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
                            if(isset($_POST["up_skills"])){
                              $up_skills = strtoupper(implode($_POST["up_skills"], ','));
                            }else{
                              $up_skills = null;
                            }
                            if(isset($_POST["up_acad_recognition"])){
                              $up_acad_recognition = strtoupper(implode($_POST["up_acad_recognition"], ','));
                            }else{
                              $up_acad_recognition = null;
                            }
                            if(isset($_POST["up_mem_assoc_org"])){
                              $up_mem_assoc_org = strtoupper(implode($_POST["up_mem_assoc_org"], ','));
                            }else{
                              $up_mem_assoc_org = null;
                            }

                            $in = DB::run("UPDATE other_info SET skills = ?, acad_recognition = ?, mem_assoc_org = ? WHERE employeeid = ? AND itemno = ?", [$up_skills, $up_acad_recognition, $up_mem_assoc_org, (isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

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

                        // adding item : Not Functional
                        $add = false;
                        if (isset($_POST["training_title"])) {
                          for ($i=0; $i < count($_POST["training_title"]); $i++) {
                            $skills = strtoupper(implode($_POST["skills"]), ',');
                            $acad_recognition = strtoupper(implode($_POST["acad_recognition"]), ',');
                            $mem_assoc_org = strtoupper(implode($_POST["mem_assoc_org"]), ',');

                            $in = DB::run("INSERT INTO training_prog(employeeid, skills, acad_recognition, mem_assoc_org) VALUES(?, ?, ?, ?)", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $skills, $acad_recognition, $mem_assoc_org]);

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
                          $del = DB::run("DELETE FROM other_info WHERE employeeid = ? AND itemno = ?", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
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
                        <div class="row">
                          <?php
                            $ret = DB::run("SELECT * FROM other_info WHERE employeeid = ?", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"])]);

                            while($row = $ret->fetch()){
                              $skills = explode(',', $row["skills"]);
                              $acad_recognition = explode(',', $row["acad_recognition"]);
                              $mem_assoc_org = explode(',', $row["mem_assoc_org"]);
                          ?>
                          <input type="text" name="up_itemno[]" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <!-- skills -->
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <?php
                              if($skills[0] != ''){
                                $counter = 1;
                                foreach ($skills as $key => $value) {
                            ?>
                              <label class="<?php echo "arow" . $counter; ?>">Item <?php echo "#" . $counter; ?>:</label>
                              <div class="input-group <?php echo "arow" . $counter; ?>">
                                <input type="text" name="up_skills[]" data-toggle="tooltip" data-placement="top" title="Special Skills and Hobbies" class="form-control" value="<?php echo $value; ?>">
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger" onclick="remRow('.arow<?php echo $counter; ?>')"><span class="fa fa-trash"></span></button>
                                </span>
                              </div>
                            <?php
                                  $counter++;
                                }
                              }
                            ?>
                          </div>
                          <!-- academic -->
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <?php
                              if($acad_recognition[0] != ''){
                                $counter = 1;
                                foreach ($acad_recognition as $key => $value) {
                            ?>
                              <label class="<?php echo "brow" . $counter; ?>">Item <?php echo "#" . $counter; ?>:</label>
                              <div class="input-group <?php echo "brow" . $counter; ?>">
                                <input type="text" name="up_acad_recognition[]" data-toggle="tooltip" data-placement="top" title="Non-Academic Distinctions / Recognition (Write in full)" class="form-control" value="<?php echo $value; ?>">
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger" onclick="remRow('.brow<?php echo $counter; ?>')"><span class="fa fa-trash"></span></button>
                                </span>
                              </div>
                            <?php
                                  $counter++;
                                }
                              }
                            ?>
                          </div>
                          <!-- membership -->
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <?php
                              if($mem_assoc_org[0] != ''){
                                $counter = 1;
                                foreach ($mem_assoc_org as $key => $value) {
                            ?>
                              <label class="<?php echo "crow" . $counter; ?>">Item <?php echo "#" . $counter; ?>:</label>
                              <div class="input-group <?php echo "crow" . $counter; ?>">
                                <input type="text" name="up_mem_assoc_org[]" data-toggle="tooltip" data-placement="top" title="Membership in Association / Organization (Write in full)" class="form-control" value="<?php echo $value; ?>">
                                <span class="input-group-btn">
                                  <button type="button" class="btn btn-danger" onclick="remRow('.crow<?php echo $counter; ?>')"><span class="fa fa-trash"></span></button>
                                </span>
                              </div>
                            <?php
                                  $counter++;
                                }
                              }
                            ?>
                          </div>
                          <?php

                            }
                          ?>
                        </div>
                        &nbsp;
                        <hr/>
                        <div id="item_container_hobbies" class="col-md-4 col-sm-12 col-xs-12">
                          <input type="button" id="add_hobbies" name="up_skills[]" value="Add Hobbies" class="btn btn-info btn-sm">
                          <br/>
                        </div>
                        <div id="item_container_recognition" class="col-md-4 col-sm-12 col-xs-12">
                          <input type="button" id="add_recognition" name="up_acad_recognition[]" value="Add Recognition" class="btn btn-info btn-sm">
                          <br/>
                        </div>
                        <div id="item_container_membership" class="col-md-4 col-sm-12 col-xs-12">
                          <input type="button" id="add_membership" name="up_mem_assoc_org[]" value="Add Membership" class="btn btn-info btn-sm">
                          <br/>
                        </div>
                        <!-- Commands -->
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
      function addHobbies(counter){
        var label = "<label class=\"irow" + counter + " labelText\">Item #" + counter + ":</label>";
        var template = "<div class=\"irow" + counter + " row\">" +
                          "<div class=\"col-md-10 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"up_skills[]\" placeholder=\"Special Skills and Hobbies\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<button type=\"button\" class=\"btn btn-danger\" onclick=\"removeRow('.irow" + counter + "')\"><span class=\"fa fa-close\"></span></button>" +
                          "</div>" +
                        "</div>";
        $("#item_container_hobbies").append(label + template);
      }
      function addRecognition(counter){
        var label = "<label class=\"rrow" + counter + " rlabelText\">Item #" + counter + ":</label>";
        var template = "<div class=\"rrow" + counter + " row\">" +
                          "<div class=\"col-md-10 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"up_acad_recognition[]\" placeholder=\"Non-Academic Distinctions/Recognition (Write in full)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<button type=\"button\" class=\"btn btn-danger\" onclick=\"rremoveRow('.rrow" + counter + "')\"><span class=\"fa fa-close\"></span></button>" +
                          "</div>" +
                        "</div>";
        $("#item_container_recognition").append(label + template);
      }
      function addMembership(counter){
        var label = "<label class=\"mrow" + counter + " mlabelText\">Item #" + counter + ":</label>";
        var template = "<div class=\"mrow" + counter + " row\">" +
                          "<div class=\"col-md-10 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"up_mem_assoc_org[]\" placeholder=\"Membership in Association/Organition (Write in full)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<button type=\"button\" class=\"btn btn-danger\" onclick=\"mremoveRow('.mrow" + counter + "')\"><span class=\"fa fa-close\"></span></button>" +
                          "</div>" +
                        "</div>";
        $("#item_container_membership").append(label + template);
      }

      function remRow(id){
        $(id).remove();
      }

      var hcounter = 1;
      $("#add_hobbies").on('click', function(){
        addHobbies(hcounter);
        hcounter++;
        resCount();
      });
      var rcounter = 1;
      $("#add_recognition").on('click', function(){
        addRecognition(rcounter);
        rcounter++;
        rresCount();
      });
      var mcounter = 1;
      $("#add_membership").on('click', function(){
        addMembership(mcounter);
        mcounter++;
        mresCount();
      });
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
