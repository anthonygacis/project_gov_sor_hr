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
                    <h2>Yes-No Questions</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <?php
                      if(isset($_POST["submit"])){

                        // updating item
                        $mod = false;
                        if (isset($_POST["up_itemno"])) {
                          $up_itemno = $_POST["up_itemno"];
                          // ====
                          if($_POST["i_34_a"] == 'yes'){
                            $i_34_a = 1;
                          }else{
                            $i_34_a = 0;
                          }
                          if($_POST["i_34_b"] == 'yes'){
                            $i_34_b = 1;
                          }else{
                            $i_34_b = 0;
                          }
                          $i_34_yes_details = strtoupper($_POST["i_34_yes_details"]);
                          // ====
                          if($_POST["i_35_a"] == 'yes'){
                            $i_35_a = 1;
                          }else{
                            $i_35_a = 0;
                          }
                          $i_35_a_yes_details = strtoupper($_POST["i_35_a_yes_details"]);
                          // ====
                          if($_POST["i_35_b"] == 'yes'){
                            $i_35_b = 1;
                          }else{
                            $i_35_b = 0;
                          }
                          if($_POST["i_35_b_date_filed"] == ''){
                            $i_35_b_date_filed = null;
                          }else{
                            $i_35_b_date_filed = $_POST["i_35_b_date_filed"];
                          }
                          $i_35_b_status_cases = strtoupper($_POST["i_35_b_status_cases"]);
                          // ====
                          if($_POST["i_36"] == 'yes'){
                            $i_36 = 1;
                          }else{
                            $i_36 = 0;
                          }
                          $i_36_yes_details = strtoupper($_POST["i_36_yes_details"]);
                          // ====
                          if($_POST["i_37"] == 'yes'){
                            $i_37 = 1;
                          }else{
                            $i_37 = 0;
                          }
                          $i_37_yes_details = strtoupper($_POST["i_37_yes_details"]);
                          // ====
                          if($_POST["i_38_a"] == 'yes'){
                            $i_38_a = 1;
                          }else{
                            $i_38_a = 0;
                          }
                          $i_38_a_yes_details = strtoupper($_POST["i_38_a_yes_details"]);
                          // ====
                          if($_POST["i_38_b"] == 'yes'){
                            $i_38_b = 1;
                          }else{
                            $i_38_b = 0;
                          }
                          $i_38_b_yes_details = strtoupper($_POST["i_38_b_yes_details"]);
                          // ====
                          if($_POST["i_39"] == 'yes'){
                            $i_39 = 1;
                          }else{
                            $i_39 = 0;
                          }
                          $i_39_yes_details = strtoupper($_POST["i_39_yes_details"]);
                          // ====
                          if($_POST["i_40_a"] == 'yes'){
                            $i_40_a = 1;
                          }else{
                            $i_40_a = 0;
                          }
                          $i_40_a_yes_details = strtoupper($_POST["i_40_a_yes_details"]);
                          // ====
                          if($_POST["i_40_b"] == 'yes'){
                            $i_40_b = 1;
                          }else{
                            $i_40_b = 0;
                          }
                          $i_40_b_yes_details = strtoupper($_POST["i_40_b_yes_details"]);
                          // ====
                          if($_POST["i_40_c"] == 'yes'){
                            $i_40_c = 1;
                          }else{
                            $i_40_c = 0;
                          }
                          $i_40_c_yes_details = strtoupper($_POST["i_40_c_yes_details"]);
                          // ====

                          $in = DB::run("UPDATE back_related SET i_34_a = ?, i_34_b = ?, i_34_yes_details = ?, i_35_a = ?, i_35_a_yes_details = ?, i_35_b = ?, i_35_b_date_filed = ?, i_35_b_status_cases = ?, i_36 = ?, i_36_yes_details = ?, i_37 = ?, i_37_yes_details = ?, i_38_a = ?, i_38_a_yes_details = ?, i_38_b = ?, i_38_b_yes_details = ?, i_39 = ?, i_39_yes_details = ?, i_40_a = ?, i_40_a_yes_details = ?, i_40_b = ?, i_40_b_yes_details = ?, i_40_c = ?, i_40_c_yes_details = ? WHERE employeeid = ? AND itemno = ?", [$i_34_a, $i_34_b, $i_34_yes_details, $i_35_a, $i_35_a_yes_details, $i_35_b, $i_35_b_date_filed, $i_35_b_status_cases, $i_36, $i_36_yes_details, $i_37, $i_37_yes_details, $i_38_a, $i_38_a_yes_details, $i_38_b, $i_38_b_yes_details, $i_39, $i_39_yes_details, $i_40_a, $i_40_a_yes_details, $i_40_b, $i_40_b_yes_details, $i_40_c, $i_40_c_yes_details, (isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"]), $up_itemno]);

                          if($in->rowCount() > 0){
                            $mod = true;
                          }
                        }

                        if($mod){
                    ?>
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                      <strong>Success!</strong> Data has been modified
                    </div>
                    <?php
                        }
                      }
                    ?>
                    <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <div class="row">
                        <?php
                          $ret = DB::run("SELECT * FROM back_related WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                          $row = $ret->fetch();
                        ?>
                        <div class="row">
                          <input type="text" name="up_itemno" value="<?php echo $row["itemno"]; ?>" style="display: none;">
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th style="width: 30%;"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 5%;">a. within the third degree?</td>
                                  <td>
                                    <label><input type="radio" name="i_34_a" value="yes" <?php echo ($row["i_34_a"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_34_a" value="no" <?php echo ($row["i_34_a"] == 0 ? 'checked' : '')?>> NO</label>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 5%;">b. within the fourth degree (for Local Government Unit - Career Employees)?</td>
                                  <td>
                                    <label><input type="radio" name="i_34_b" value="yes" <?php echo ($row["i_34_b"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_34_b" value="no" <?php echo ($row["i_34_b"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_34_yes_details" name="i_34_yes_details" class="form-control" value="<?php echo $row["i_34_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_34_b"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>35. a. Have you ever been found guilty of any administrative offense?</td>
                                  <td>
                                    <label><input type="radio" name="i_35_a" value="yes" <?php echo ($row["i_35_a"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_35_a" value="no" <?php echo ($row["i_35_a"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_35_a_yes_details" name="i_35_a_yes_details" class="form-control" value="<?php echo $row["i_35_a_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_35_a"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 2%;">b. Have you been criminally charged before any court?</td>
                                  <td>
                                    <label><input type="radio" name="i_35_b" value="yes" <?php echo ($row["i_35_b"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_35_b" value="no" <?php echo ($row["i_35_b"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="date" id="i_35_b_date_filed" name="i_35_b_date_filed" class="form-control" placeholder="Give Details" data-toggle="tooltip" data-placement="top" title="Date Filed" <?php echo ($row["i_35_b"] == 0 ? "style=\"display: none;\"" : '')?> value="<?php echo $row["i_35_b_date_filed"]; ?>">
                                    <input type="text" id="i_35_b_status_cases" name="i_35_b_status_cases" class="form-control" value="<?php echo $row["i_35_b_status_cases"]; ?>" placeholder="Give Details" data-toggle="tooltip" data-placement="top" title="Status of Case/s" <?php echo ($row["i_35_b"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?</td>
                                  <td>
                                    <label><input type="radio" name="i_36" value="yes" <?php echo ($row["i_36"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_36" value="no" <?php echo ($row["i_36"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_36_yes_details" name="i_36_yes_details" class="form-control" value="<?php echo $row["i_36_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_36"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?</td>
                                  <td>
                                    <label><input type="radio" name="i_37" value="yes" <?php echo ($row["i_37"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_37" value="no" <?php echo ($row["i_37"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_37_yes_details" name="i_37_yes_details" class="form-control" value="<?php echo $row["i_37_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_37"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>38. a. Have you ever been a candidate in a national or local held within the last year (except Barangay election)?</td>
                                  <td>
                                    <label><input type="radio" name="i_38_a" value="yes" <?php echo ($row["i_38_a"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_38_a" value="no" <?php echo ($row["i_38_a"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_38_a_yes_details" name="i_38_a_yes_details" class="form-control" value="<?php echo $row["i_38_a_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_38_a"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 2%;">b. Have you resigned from the government service during the three(3)-month period before the last election to promote/actively campaign for a national or local candidate?</td>
                                  <td>
                                    <label><input type="radio" name="i_38_b" value="yes" <?php echo ($row["i_38_b"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_38_b" value="no" <?php echo ($row["i_38_b"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_38_b_yes_details" name="i_38_b_yes_details" class="form-control" value="<?php echo $row["i_38_b_yes_details"]; ?>" placeholder="Give Details" <?php echo ($row["i_38_b"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>39. Have you acquired the status of an immigrant or permanent resident of another country?</td>
                                  <td>
                                    <label><input type="radio" name="i_39" value="yes" <?php echo ($row["i_39"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_39" value="no" <?php echo ($row["i_39"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_39_yes_details" name="i_39_yes_details" class="form-control" value="<?php echo $row["i_39_yes_details"]; ?>" placeholder="Give Details (Country)" <?php echo ($row["i_39"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td>40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 5%;">a. Are you a member of any indigenous group?</td>
                                  <td>
                                    <label><input type="radio" name="i_40_a" value="yes" <?php echo ($row["i_40_a"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_40_a" value="no" <?php echo ($row["i_40_a"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_40_a_yes_details" name="i_40_a_yes_details" class="form-control" value="<?php echo $row["i_40_a_yes_details"]; ?>" placeholder="Please specify" <?php echo ($row["i_40_a"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 5%;">b. Are you a person with disability</td>
                                  <td>
                                    <label><input type="radio" name="i_40_b" value="yes" <?php echo ($row["i_40_b"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_40_b" value="no" <?php echo ($row["i_40_b"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_40_b_yes_details" name="i_40_b_yes_details" class="form-control" value="<?php echo $row["i_40_b_yes_details"]; ?>" placeholder="Please specify ID No." <?php echo ($row["i_40_b"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                                <tr>
                                  <td style="text-indent: 5%;">c. Are you a solo parent?</td>
                                  <td>
                                    <label><input type="radio" name="i_40_c" value="yes" <?php echo ($row["i_40_c"] == 1 ? 'checked' : '')?>> YES</label>
                                    <label><input type="radio" name="i_40_c" value="no" <?php echo ($row["i_40_c"] == 0 ? 'checked' : '')?>> NO</label>
                                    <input type="text" id="i_40_c_yes_details" name="i_40_c_yes_details" class="form-control" value="<?php echo $row["i_40_c_yes_details"]; ?>" placeholder="Please specify ID No." <?php echo ($row["i_40_c"] == 0 ? "style=\"display: none;\"" : '')?>>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
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


    <script>
      $('input[name=i_34_b]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_34_yes_details').show();
        }else{
          $('#i_34_yes_details').hide();
        }
      });
      $('input[name=i_35_a]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_35_a_yes_details').show();
        }else{
          $('#i_35_a_yes_details').hide();
        }
      });
      $('input[name=i_35_b]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_35_b_date_filed').show();
          $('#i_35_b_status_cases').show();
        }else{
          $('#i_35_b_date_filed').hide();
          $('#i_35_b_status_cases').hide();
        }
      });
      $('input[name=i_36]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_36_yes_details').show();
        }else{
          $('#i_36_yes_details').hide();
        }
      });
      $('input[name=i_37]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_37_yes_details').show();
        }else{
          $('#i_37_yes_details').hide();
        }
      });
      $('input[name=i_38_a]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_38_a_yes_details').show();
        }else{
          $('#i_38_a_yes_details').hide();
        }
      });
      $('input[name=i_38_b]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_38_b_yes_details').show();
        }else{
          $('#i_38_b_yes_details').hide();
        }
      });
      $('input[name=i_39]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_39_yes_details').show();
        }else{
          $('#i_39_yes_details').hide();
        }
      });
      $('input[name=i_40_a]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_40_a_yes_details').show();
        }else{
          $('#i_40_a_yes_details').hide();
        }
      });
      $('input[name=i_40_b]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_40_b_yes_details').show();
        }else{
          $('#i_40_b_yes_details').hide();
        }
      });
      $('input[name=i_40_c]').on('change', function(){
        if($(this).val() == 'yes'){
          $('#i_40_c_yes_details').show();
        }else{
          $('#i_40_c_yes_details').hide();
        }
      });

    </script>
  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>
