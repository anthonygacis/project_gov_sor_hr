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
                  <a href="employee.php" class="btn btn-info"><span class="fa fa-arrow-left"></span> Go Back (Employee)</a><a href="educational_background.php?employeeid=<?php echo $_GET["employeeid"];?>" class="btn btn-success"><span class="fa fa-arrow-right"></span> Next (Educational Background)</a>
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
                    <h2>Family Background</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submit"])){
                        $spouselname = strtoupper($_POST["spouselname"]);
                        $spousefname = strtoupper($_POST["spousefname"]);
                        $spousemname = strtoupper($_POST["spousemname"]);
                        $sp_occupation = strtoupper($_POST["sp_occupation"]);
                        $sp_employer = strtoupper($_POST["sp_employer"]);
                        $sp_empraddr = strtoupper($_POST["sp_employer"]);
                        $sp_emprtelno = strtoupper($_POST["sp_emprtelno"]);
                        $fatherlname = strtoupper($_POST["fatherlname"]);
                        $fatherfname = strtoupper($_POST["fatherlname"]);
                        $fathermname = strtoupper($_POST["fathermname"]);
                        $motherlname = strtoupper($_POST["motherlname"]);
                        $motherfname = strtoupper($_POST["motherfname"]);
                        $mothermname = strtoupper($_POST["mothermname"]);

                        $up  = DB::run("UPDATE employee SET spouselname = ?, spousefname = ?, spousemname = ?, sp_occupation = ?, sp_employer = ?, sp_empraddr = ?, sp_emprtelno = ?, fatherlname = ?, fatherfname = ?, fathermname = ?, motherlname = ?, motherfname = ?, mothermname = ? WHERE employeeid = ?", [$spouselname, $spousefname, $spousemname, $sp_occupation, $sp_employer, $sp_empraddr, $sp_emprtelno, $fatherlname, $fatherfname, $fathermname, $motherlname, $motherfname, $mothermname, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);

                        // updating children
                        if (isset($_POST["update_children"])) {
                          for ($i=0; $i < count($_POST["update_children"]); $i++) {
                            $update_children_itemno = $_POST["update_children_itemno"][$i];
                            $update_children = strtoupper($_POST["update_children"][$i]);
                            $update_children_birthdate = strtoupper($_POST["update_children_birthdate"][$i]);

                            $in = DB::run("UPDATE empchildren SET childname = ?, birthdate = ? WHERE employeeid = ? AND itemno = ?", [$update_children, $update_children_birthdate, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $update_children_itemno]);

                          }
                        }

                        // adding children
                        if (isset($_POST["children"])) {
                          for ($i=0; $i < count($_POST["children"]); $i++) {
                            if($_POST["children"][$i] == ""){
                              continue;
                            }
                            $child_name = strtoupper($_POST["children"][$i]);
                            $child_birthdate = strtoupper($_POST["children_birthdate"][$i]);

                            $in = DB::run("INSERT INTO empchildren(employeeid, childname, birthdate) VALUES(?,?,?)", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $child_name, $child_birthdate]);

                          }
                        }

                        if($up->rowCount() > 0 || $in->rowCount() > 0){
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
                          $del = DB::run("DELETE FROM empchildren WHERE employeeid = ? AND itemno = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $_GET["itemno"]]);
                          if($del->rowCount() > 0){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been deleted
                    </div>
                    <?php
                          }
                        }else{
                          header("Location: family_background.php");
                        }
                      }
                    ?>

                    <?php
                      // retrieve employee personal info
                      $ret = DB::run("SELECT * FROM employee WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                      if($row = $ret->fetch()){
                        $spouselname = $row["spouselname"];
                        $spousefname = $row["spousefname"];
                        $spousemname = $row["spousemname"];
                        $sp_occupation = $row["sp_occupation"];
                        $sp_employer = $row["sp_employer"];
                        $sp_empraddr = $row["sp_empraddr"];
                        $sp_emprtelno = $row["sp_emprtelno"];
                        $fatherlname = $row["fatherlname"];
                        $fatherfname = $row["fatherfname"];
                        $fathermname = $row["fathermname"];
                        $motherlname = $row["motherlname"];
                        $motherfname = $row["motherfname"];
                        $mothermname = $row["mothermname"];
                      }
                    ?>
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Spouse's Surname:</label>
                          <input type="text" name="spouselname" placeholder="Enter text ..." class="form-control" value="<?php echo $spouselname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Spouse's First Name:</label>
                          <input type="text" name="spousefname" placeholder="Enter text ..." class="form-control" value="<?php echo $spousefname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Spouse's Middle Name:</label>
                          <input type="text" name="spousemname" placeholder="Enter text ..." class="form-control" value="<?php echo $spousemname; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                          <label>Occupation:</label>
                          <input type="text" name="sp_occupation" placeholder="Enter text ..." class="form-control" value="<?php echo $sp_occupation; ?>">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                          <label>Employer / Business Name:</label>
                          <input type="text" name="sp_employer" placeholder="Enter text ..." class="form-control" value="<?php echo $sp_employer; ?>">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                          <label>Business Address:</label>
                          <input type="text" name="sp_empraddr" placeholder="Enter text ..." class="form-control" value="<?php echo $sp_empraddr; ?>">
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                          <label>Telephone No:</label>
                          <input type="text" name="sp_emprtelno" placeholder="Enter text ..." class="form-control" value="<?php echo $sp_emprtelno; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Father's Surname:</label>
                          <input type="text" name="fatherlname" placeholder="Enter text ..." class="form-control" value="<?php echo $fatherlname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Father's First Name:</label>
                          <input type="text" name="fatherfname" placeholder="Enter text ..." class="form-control" value="<?php echo $fatherfname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Father's Middle Name:</label>
                          <input type="text" name="fathermname" placeholder="Enter text ..." class="form-control" value="<?php echo $fathermname; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Mother's Last Name:</label>
                          <input type="text" name="motherlname" placeholder="Enter text ..." class="form-control" value="<?php echo $motherlname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Mother's First Name:</label>
                          <input type="text" name="motherfname" placeholder="Enter text ..." class="form-control" value="<?php echo $motherfname; ?>">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Mother's Middle Name:</label>
                          <input type="text" name="mothermname" placeholder="Enter text ..." class="form-control" value="<?php echo $mothermname; ?>">
                        </div>
                        <div class="clearfix"></div>
                        <hr/>
                        <label>Name of Children:</label>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group" id="children_container">
                          <?php
                            // retrieve children
                            $child = DB::run("SELECT * FROM empchildren WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                            while($row = $child->fetch()){
                          ?>
                          <input type="text" name="update_children_itemno[]"  value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                            <input type="text" name="update_children[]" placeholder="Child's Name" class="form-control" value="<?php echo $row["childname"]; ?>">
                          </div>
                          <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                            <input type="date" name="update_children_birthdate[]" placeholder="Child's Birthdate" class="form-control" value="<?php echo $row["birthdate"]; ?>">
                          </div>
                          <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <a href="family_background.php?<?php echo 'employeeid=' . (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]) . '&itemno=' . $row["itemno"]; ?>" class="btn btn-danger"><span class="fa fa-times"></span> Delete</a>
                          </div>
                          <?php
                            }
                          ?>
                        </div>

                        <!-- Commands -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <br/>
                          <input type="button" id="add_child" value="Add Child" class="btn btn-info">
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


    <script>
      function addChild(counter){
        var child_template = "<div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"text\" name=\"children[]\" placeholder=\"" + counter + " Child's Name\" class=\"form-control\">" +
                          "</div>";
        var child_birthdate_template = "<div class=\"col-md-6 col-sm-12 col-xs-12 form-group\">" +
                            "<input type=\"date\" name=\"children_birthdate[]\" placeholder=\"" + counter + " Child's Birthdate\" class=\"form-control\">" +
                          "</div>";
        $("#children_container").append(child_template + child_birthdate_template);
      }

      var counter = 1;
      $("#add_child").on('click', function(){
        addChild(counter);
        counter++;
      });
    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
