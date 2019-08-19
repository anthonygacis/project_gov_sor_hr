<?php
  include "connection/connection.php";
  session_start();

  if(!isset($_SESSION["username"])){
    header("Location: login.php");
  }

  if(!isset($_GET["employeeid"])){
    header("Location: index.php");
  }else{
    if($_GET["employeeid"] == ""){
      header("Location: index.php");
    }
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

        <?php
          $ret = DB::run("SELECT * FROM employee WHERE employeeid = ?", [$_GET["employeeid"]]);
          if($row = $ret->fetch()){
            $full_name = $row["lname"] . ", " . $row["fname"] . " " . $row["midinit"];

            
          }
        ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo "Employee Name: " .  $full_name; ?></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <?php
              // retrieve employee personal info
              $ret = DB::run("SELECT * FROM employee WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
              if($row = $ret->fetch()){
                $lname = $row["lname"];
                $fname = $row["fname"];
                $mname = $row["midname"];
                $birthdate = $row["birthdate"];
                $birthplace = $row["birthplace"];
                $gender = $row["gender"];
                $civilstatus = $row["civilstatus"];
                $height = $row["height"];
                $weight = $row["weight"];
                $bloodtype = $row["bloodtype"];
                $gsisno = $row["gsisno"];
                $pagibigno = $row["pagibigno"];
                $philhealthno = $row["philhealthno"];
                $sssno = $row["sssno"];
                $tinno = $row["tinno"];
                $agencyemployeeno = $row["agencyemployeeno"];
                $citizenship = $row["citizenship"];
                $residentialaddr1 = $row["residentialaddr1"];
                $reszipcode = $row["reszipcode"];
                $permanentaddr1 = $row["permanentaddr1"];
                $permzipcode = $row["permzipcode"];
                $telno = $row["telno"];
                $mobileno = $row["mobileno"];
                $emailaddr = $row["emailaddr"];

              }
            ?>
            
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Personal Information</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- start accordion -->
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel">
                        <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <h4 class="panel-title">Personal Information</h4>
                        </a>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                          <div class="panel-body">
                            <form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="POST">
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Surname:</label>
                                  <input type="text" class="form-control" required value="<?php echo $lname; ?>" disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>First Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $fname; ?>" disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Middle Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $mname; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Date of Birth:</label>
                                  <input type="date" class="form-control" required value="<?php echo $birthdate; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Citizenship:</label>
                                  <input type="text" class="form-control" required value="<?php echo $citizenship; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Place of Birth:</label>
                                  <input type="text" class="form-control" required value="<?php echo $birthplace; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Sex:</label>
                                  <select class="form-control" required disabled>
                                    <option value=""> -- SELECT -- </option>
                                    <option value="M" <?php echo $gender == "M" ? "selected" : ""; ?>>Male</option>
                                    <option value="F" <?php echo $gender == "F" ? "selected" : ""; ?>>Female</option>
                                  </select>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Civil Status:</label>
                                  <select class="form-control" required disabled>
                                    <option value=""> -- SELECT -- </option>
                                    <option value="single" <?php echo $civilstatus == "single" ? "selected" : ""; ?>>Single</option>
                                    <option value="widowed" <?php echo $civilstatus == "widowed" ? "selected" : ""; ?>>Widowed</option>
                                    <option value="married" <?php echo $civilstatus == "married" ? "selected" : ""; ?>>Married</option>
                                    <option value="separated" <?php echo $civilstatus == "separated" ? "selected" : ""; ?>>Separated</option>
                                    <option value="others" <?php echo $civilstatus == "others" ? "selected" : ""; ?>>Other/s</option>
                                  </select>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Residential Address:</label>
                                  <input type="text" class="form-control" required value="<?php echo $residentialaddr1; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Height (m):</label>
                                  <input type="number" class="form-control" value="<?php echo $height; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Residential Zip Code:</label>
                                  <input type="text" class="form-control" required value="<?php echo $reszipcode; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Weight (kg):</label>
                                  <input type="number" class="form-control" value="<?php echo $weight; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Permanent Address:</label>
                                  <input type="text" class="form-control" required value="<?php echo $permanentaddr1; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Blood Type:</label>
                                  <input type="text" class="form-control" value="<?php echo $bloodtype; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Permanent Zip Code:</label>
                                  <input type="text" class="form-control" required value="<?php echo $permzipcode; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>GSIS ID No:</label>
                                  <input type="text" class="form-control" value="<?php echo $gsisno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>PAG-IBIG ID No:</label>
                                  <input type="text" class="form-control" value="<?php echo $pagibigno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>PHILHEALTH No:</label>
                                  <input type="text" class="form-control" value="<?php echo $philhealthno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>SSS No:</label>
                                  <input type="text" class="form-control" value="<?php echo $sssno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>TIN No:</label>
                                  <input type="text" class="form-control" value="<?php echo $tinno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Telephone No:</label>
                                  <input type="text" class="form-control" value="<?php echo $telno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Mobile No:</label>
                                  <input type="text" class="form-control" value="<?php echo $mobileno; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>E-mail Address:</label>
                                  <input type="text" class="form-control" value="<?php echo $emailaddr; ?>" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Agency Employee No:</label>
                                  <input type="text" class="form-control" required value="<?php echo $agencyemployeeno; ?>" disabled>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <h4 class="panel-title">Family Background</h4>
                        </a>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                          <div class="panel-body">
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
                            <form>
                              <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Spouse's Surname:</label>
                                  <input type="text" class="form-control" value="<?php echo $spouselname; ?>" disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Spouse's First Name:</label>
                                  <input type="text" class="form-control" value="<?php echo $spousefname; ?>" disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Spouse's Middle Name:</label>
                                  <input type="text" class="form-control" value="<?php echo $spousemname; ?>"disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Occupation:</label>
                                  <input type="text" class="form-control" value="<?php echo $sp_occupation; ?>"disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Employer / Business Name:</label>
                                  <input type="text" class="form-control" value="<?php echo $sp_employer; ?>"disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Business Address:</label>
                                  <input type="text" class="form-control" value="<?php echo $sp_empraddr; ?>"disabled>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                  <label>Telephone No:</label>
                                  <input type="text" class="form-control" value="<?php echo $sp_emprtelno; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Father's Surname:</label>
                                  <input type="text" class="form-control" required value="<?php echo $fatherlname; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Father's First Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $fatherfname; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Father's Middle Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $fathermname; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Mother's Last Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $motherlname; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Mother's First Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $motherfname; ?>"disabled>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                  <label>Mother's Middle Name:</label>
                                  <input type="text" class="form-control" required value="<?php echo $mothermname; ?>"disabled>
                                </div>
                                  <label>Name of Children:</label>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group" id="children_container">
                                  <?php
                                    // retrieve children
                                    $child = DB::run("SELECT * FROM empchildren WHERE employeeid = ?", [(isset($employeeid) && $_SESSION["user_type"] == "admin" ? $employeeid : $_SESSION["employeeid"])]);
                                    while($row = $child->fetch()){
                                  ?>
                                  <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" value="<?php echo $row["childname"]; ?>" disabled>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <input type="date" class="form-control" value="<?php echo $row["birthdate"]; ?>" disabled>
                                  </div>
                                  <?php
                                    }
                                  ?>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          <h4 class="panel-title">Educational Background</h4>
                        </a>
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                          <div class="panel-body">
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
                                    <select class="form-control" data-toggle="tooltip" data-placement="top" title="Educational Level" readonly>
                                      <option value=""> -- Select Education Level -- </option>
                                      <option value="elementary" <?php echo $educlevel == "elementary" ? "selected" : ""; ?>>Elementary</option>
                                      <option value="secondary" <?php echo $educlevel == "secondary" ? "selected" : ""; ?>>Secondary</option>
                                      <option value="vocational" <?php echo $educlevel == "vocational" ? "selected" : ""; ?>>Vocational / Trade Course</option>
                                      <option value="college" <?php echo $educlevel == "college" ? "selected" : ""; ?>>College</option>
                                      <option value="graduate" <?php echo $educlevel == "graduate" ? "selected" : ""; ?>>Graduate Studies</option>
                                    </select>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" required value="<?php echo $schoolname; ?>" data-toggle="tooltip" data-placement="top" title="Name of School" readonly>
                                  </div>
                                  <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" required value="<?php echo $degree; ?>" data-toggle="tooltip" data-placement="top" title="Basic Education/Degree/Course" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <input type="number" min="0" class="form-control" required value="<?php echo $periodfrom; ?>" data-toggle="tooltip" data-placement="top" title="Period of Attendance (From)" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <input type="number" min="0" class="form-control" required value="<?php echo $periodto; ?>" data-toggle="tooltip" data-placement="top" title="Period of Attendance (To)" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <input type="number" class="form-control" value="<?php echo $unitsearned; ?>" data-toggle="tooltip" data-placement="top" title="Highest Level/Units Earned" readonly>
                                  </div>
                                  <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                                    <input type="number" min="0" class="form-control" required value="<?php echo $yrgraduate; ?>" data-toggle="tooltip" data-placement="top" title="Year Graduated" readonly>
                                  </div>
                                  <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" value="<?php echo $honors; ?>" data-toggle="tooltip" data-placement="top" title="Scholarship / Academic Honors Received" readonly>
                                  </div>
                                </div>
                                <?php
                                    $counter++;
                                  }
                                ?>
                                
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="panel">
                        <a class="panel-heading collapsed" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                          <h4 class="panel-title">Licenses</h4>
                        </a>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                          <div class="panel-body">
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
                                  <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" required value="<?php echo $licensename; ?>" data-toggle="tooltip" data-placement="top" title="License Name" readonly>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" required value="<?php echo $rating; ?>" data-toggle="tooltip" data-placement="top" title="Rating" readonly>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <input type="date" class="form-control" required value="<?php echo $examdate; ?>" data-toggle="tooltip" data-placement="top" title="Exam Date" readonly>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" required value="<?php echo $place; ?>" data-toggle="tooltip" data-placement="top" title="Place" readonly>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <input type="text" class="form-control" value="<?php echo $licenseno; ?>" data-toggle="tooltip" data-placement="top" title="License No." readonly>
                                  </div>
                                  <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                    <input type="date" class="form-control" required value="<?php echo $validdate; ?>" data-toggle="tooltip" data-placement="top" title="Valid Date" readonly>
                                  </div>
                                </div>
                                <?php
                                    $counter++;
                                  }
                                ?>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- end of accordion -->
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

  </body>
  <script>
  if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
</html>

