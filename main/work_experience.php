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
                  <a href="org_involvement.php?employeeid=<?php echo $_GET["employeeid"];?>" class="btn btn-success"><span class="fa fa-arrow-right"></span> Next (Voluntary Work)</a>
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
                    <h2>Work Experience</h2>
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
                            if($_POST["up_inclusivedate_to"][$i] != ''){
                              $up_inclusivedate_to = $_POST["up_inclusivedate_to"][$i];
                              $up_is_present = 0;
                            }else{
                              $up_inclusivedate_to = null;
                              $up_is_present = 1;
                            }

                            $up_position_title = strtoupper($_POST["up_position_title"][$i]);
                            $up_agency_name = strtoupper($_POST["up_agency_name"][$i]);
                            $up_monthly_salary = strtoupper($_POST["up_monthly_salary"][$i]);
                            $up_salary_grade = strtoupper($_POST["up_salary_grade"][$i]);
                            $up_status_of_appointment = strtoupper($_POST["up_status_of_appointment"][$i]);
                            $up_is_gov_service = $_POST["up_is_gov_service"][$i];

                            $in = DB::run("UPDATE work_experience SET inclusivedate_from = ?, inclusivedate_to = ?, position_title = ?, agency_name = ?, monthly_salary = ?, salary_grade = ?, status_of_appointment = ?, is_gov_service = ?, is_present = ? WHERE employeeid = ? AND itemno = ?", [$up_inclusivedate_from, $up_inclusivedate_to, $up_position_title, $up_agency_name, $up_monthly_salary, $up_salary_grade, $up_status_of_appointment, ($up_is_gov_service == 'yes' ? 1 : 0), $up_is_present, (isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

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
                        if (isset($_POST["position_title"])) {
                          for ($i=0; $i < count($_POST["position_title"]); $i++) {
                            $inclusivedate_from = $_POST["inclusivedate_from"][$i];
                            if($_POST["inclusivedate_to"][$i] == ''){
                              $inclusivedate_to = null;
                              $is_present = 1;
                            }else{
                              $inclusivedate_to = $_POST["inclusivedate_to"][$i];
                              $is_present = 0;
                            }
                            $position_title = strtoupper($_POST["position_title"][$i]);
                            $agency_name = strtoupper($_POST["agency_name"][$i]);
                            $monthly_salary = strtoupper($_POST["monthly_salary"][$i]);
                            $salary_grade = strtoupper($_POST["salary_grade"][$i]);
                            $status_of_appointment = strtoupper($_POST["status_of_appointment"][$i]);
                            $is_gov_service = $_POST["is_gov_service"][$i];

                            $in = DB::run("INSERT INTO work_experience(employeeid, inclusivedate_from, inclusivedate_to, position_title, agency_name, monthly_salary, salary_grade, status_of_appointment, is_gov_service, is_present) VALUES(?,?,?,?,?,?,?,?,?,?)", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $inclusivedate_from, $inclusivedate_to, $position_title, $agency_name, $monthly_salary, $salary_grade, $status_of_appointment, ($is_gov_service == 'yes' ? 1 : 0), $is_present]);

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
                          $del = DB::run("DELETE FROM work_experience WHERE employeeid = ? AND itemno = ?", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
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
                          $ret = DB::run("SELECT * FROM work_experience WHERE employeeid = ?", [(isset($employeeid)  ? $employeeid : $_SESSION["employeeid"])]);
                          $counter = 1;
                          while($row = $ret->fetch()){
                            $inclusivedate_from = $row["inclusivedate_from"];
                            $inclusivedate_to = $row["inclusivedate_to"];
                            $position_title = $row["position_title"];
                            $agency_name = $row["agency_name"];
                            $monthly_salary = $row["monthly_salary"];
                            $salary_grade = $row["salary_grade"];
                            $status_of_appointment = $row["status_of_appointment"];
                            $is_gov_service = $row["is_gov_service"];
                            $is_present = $row["is_present"];
                        ?>
                        <label>Row <?php echo "#" . $counter; ?>:</label>
                        <div class="row">
                          <input type="text" name="up_itemno[]" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>From:</label>
                            <input type="date" name="up_inclusivedate_from[]" data-toggle="tooltip" data-placement="top" title="Inclusive Dates (From)" class="form-control" value="<?php echo $row["inclusivedate_from"]; ?>" required>
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <label>To:</label>
                            <input type="date" name="up_inclusivedate_to[]" data-toggle="tooltip" data-placement="top" title="Inclusive Dates (To)" class="form-control" value="<?php echo $row["inclusivedate_to"]; ?>" <?php echo ($is_present == 1) ? 'readonly' : '' ?> id="iTo<?php echo $counter; ?>" required>
                          </div>
                          <div class="col-md-1 col-sm-12 col-xs-12 form-group">
                            <label>Present Job?</label> <br/>
                            <label><input type="checkbox" name="up_is_present[]" class="isPresent" data-checkval="<?php echo $counter; ?>" <?php echo ($is_present == 1) ? 'checked' : '' ?>> Yes</label>
                          </div>
                          <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                            <label>&nbsp;</label>
                            <input type="text" name="up_position_title[]" data-toggle="tooltip" data-placement="top" title="Position Title (Write in full/Do not abbreviate)" class="form-control" value="<?php echo $row["position_title"]; ?>">
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <label>&nbsp;</label>
                            <input type="text" name="up_agency_name[]" data-toggle="tooltip" data-placement="top" title="Department/Agency/Office/Company (Write in full/Do not abbreviate)" class="form-control" value="<?php echo $row["agency_name"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_monthly_salary[]" data-toggle="tooltip" data-placement="top" title="Monthly Salary" class="form-control" value="<?php echo $row["monthly_salary"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_salary_grade[]" data-toggle="tooltip" data-placement="top" title="Salary/Job/Pay Grade (if applicable) & step (format '00-0')/increment (To)" class="form-control" value="<?php echo $row["salary_grade"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="up_status_of_appointment[]" data-toggle="tooltip" data-placement="top" title="Status of Appointment" class="form-control" value="<?php echo $row["status_of_appointment"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <select class="form-control" name="up_is_gov_service[]" data-toggle="tooltip" data-placement="top" title="Is Government Service? ">
                              <option value=""> -- Government Service (Y/N) -- </option>
                              <option value="yes" <?php echo ($is_gov_service == 1 ? 'selected' : '')?>>Yes</option>
                              <option value="no" <?php echo ($is_gov_service == 0 ? 'selected' : '')?>>No</option>
                            </select>
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <a href="work_experience.php?<?php echo 'employeeid=' . (isset($employeeid)  ? $employeeid : $_SESSION["employeeid"]) . '&itemno=' . $row["itemno"]; ?>" class="btn btn-danger btn-sm"><span class="fa fa-times"></span> Delete</a>
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
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<label>From:</label>" +
                            "<input type=\"date\" name=\"inclusivedate_from[]\" placeholder=\"Inclusive Dates (From)\" class=\"form-control\" required>" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<label>To:</label>" +
                            "<input type=\"date\" name=\"inclusivedate_to[]\" placeholder=\"Inclusive Dates (To)\" class=\"form-control\" id=\"iTo" + counter + "\" required>" +
                          "</div>" +
                          "<div class=\"col-md-1 col-sm-12 col-xs-12 form-group\">" +
                            "<label>Present Job?</label> <br/>" +
                            "<label><input type=\"checkbox\" name=\"is_present[]\" class=\"isPresent\" data-checkval=\"" + counter + "\"> Yes</label>" +
                          "</div>" +
                          "<div class=\"col-md-3 col-sm-12 col-xs-12 form-group\">" +
                            "<label>&nbsp;</label>" +
                            "<input type=\"text\" name=\"position_title[]\" placeholder=\"Position Title (Write in full/Do not abbreviate)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-4 col-sm-12 col-xs-12 form-group\">" +
                            "<label>&nbsp;</label>" +
                            "<input type=\"text\" name=\"agency_name[]\" placeholder=\"Department/Agency/Office/Company (Write in full/Do not abbreviate)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"monthly_salary[]\" placeholder=\"Monthly Salary\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"salary_grade[]\" placeholder=\"Salary/Job/Pay Grade (if applicable) & step (format '00-0')/increment (To)\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"status_of_appointment[]\" placeholder=\"Status of Appointment\" class=\"form-control\">" +
                          "</div>" +
                          "<div class=\"col-md-2 col-sm-12 col-xs-12 form-group\">" +
                            "<select class=\"form-control\" name=\"is_gov_service[]\">" +
                              "<option value=\"\"> -- Government Service (Y/N) -- </option>" +
                              "<option value=\"yes\">Yes</option>" +
                              "<option value=\"no\">No</option>" +
                            "</select>" +
                          "</div>" +
                          "<div class=\"col-md-4 col-sm-12 col-xs-12 form-group\">" +
                            "<button type=\"button\" class=\"btn btn-danger\" onclick=\"removeRow('.irow" + counter + "')\"><span class=\"fa fa-close\"></span></button>" +
                          "</div>" +
                        "</div>";
        $("#item_container").append(label + template);
      }

      var counter = <?php echo $counter; ?>;
      $("#add_item").on('click', function(){
        addItem(counter);
        counter++;
        resCount();
      });
      $(document).on('change', '[type=checkbox]', function(e){
        if(checkerOnce() > 1){
          alert('Only one job entry should be marked as present');
          $(this).prop('checked', false)
        }else{
          if($(this).prop('checked')){
            $('#iTo' + $(this).attr('data-checkval')).prop('readonly', true);
          }else{
            $('#iTo' + $(this).attr('data-checkval')).prop('readonly', false);
          }
        }
      });

      function checkerOnce(){
        var $checkboxes = $('input[type="checkbox"]');
        var totalChecked = $checkboxes.filter(':checked').length
        return totalChecked;
      }
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
