<?php
  $priviledges = $_SESSION["priviledges"];
?>
<div class="left_col scroll-view">
  <div class="navbar nav_title" style="border: 0;">
    <a href="index.html" class="site_title"><i class="fa fa-users"></i> <span>GOVSOR-EMS</span></a>
  </div>

  <div class="clearfix"></div>

  <!-- menu profile quick info -->
  <div class="profile clearfix">
    <div class="profile_pic">
      <img src="images/user.png" alt="..." class="img-circle profile_img">
    </div>
    <div class="profile_info">
      <span>Welcome,</span>
      <h2>
        <?php
          echo $_SESSION["username"];
        ?>
      </h2>
    </div>
    <div class="clearfix"></div>
  </div>
  <!-- /menu profile quick info -->

  <br />

  <!-- sidebar menu -->
  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
      <h3>General</h3>
      <ul class="nav side-menu">
        <li><a href="index.php"><i class="fa fa-user"></i> Home</a></li>
      </ul>
    </div>
    <div class="menu_section">
      <h3>Data Entry</h3>
      <ul class="nav side-menu">
        <?php
          if(strpos($priviledges, 'employee') !== false){
        ?>
        <li><a href="employee.php"><i class="fa fa-user"></i> Employee</a></li>
        <?php
          }
        ?>
        <?php
          if(strpos($priviledges, 'emp_status') !== false || strpos($priviledges, 'rank') !== false){
        ?>
        <li><a href="emp_status_rank.php"><i class="fa fa-user"></i> Employee Status and Rank</a></li>
        <?php
          }
        ?>
        <?php
          if(strpos($priviledges, 'salary_grade') !== false){
        ?>
        <li><a href="salary_grade_campus.php"><i class="fa fa-user"></i> Salary Grade</a></li>
        <?php
          }
        ?>
      </ul>
    </div>
    <?php
      if(strpos($priviledges, 'set_appointment') !== false){
    ?>
    <div class="menu_section">
      <h3>Settings</h3>
      <ul class="nav side-menu">
        <li><a href="appointment.php"><i class="fa fa-user"></i> Set Appointment</a></li>
      </ul>
    </div>
    <?php
      }
    ?>
    <?php
      if(strpos($priviledges, 'manage_account') !== false){
    ?>
    <div class="menu_section">
      <h3>Account Management</h3>
      <ul class="nav side-menu">
        <li><a href="manage_account.php"><i class="fa fa-user"></i> Manage Account</a></li>
      </ul>
    </div>
    <?php
      }
    ?>
    <div class="menu_section">
      <h3>System</h3>
      <ul class="nav side-menu">
        <li><a href="change_password.php"><i class="fa fa-user"></i> Change Password</a></li>
      </ul>
    </div>
  </div>
  <!-- /sidebar menu -->

  <!-- /menu footer buttons -->
  <div class="sidebar-footer hidden-small">
    <a data-toggle="tooltip" data-placement="top" title="Settings">
      <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
      <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Lock">
      <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
    </a>
    <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
      <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
    </a>
  </div>
  <!-- /menu footer buttons -->
</div>
