
<?php
  session_start();
  //perform logout
  if(isset($_GET['logout']) && $_GET['logout'] == 'true'){
    unset($_SESSION['Username']);
    unset($_GET['logout']);
    header("location: index.php");
  }
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <?php
          if(isset($_SESSION['Username'])&&$_SESSION['Name']=='Admin'){
            echo '<li><a href="students.php"><span class="glyphicon glyphicon-education"></span> Students</a></li>';
            echo '<li><a href="courses.php"><span class="glyphicon glyphicon-calendar"></span> Courses</a></li>';
            echo '<li><a href="teachers.php"><span class="glyphicon glyphicon-user"></span> Teachers</a></li>';
            echo '<li><a href="locations.php"><span class="glyphicon glyphicon-map-marker"></span> Locations</a></li>';
            echo '<li><a href="applications.php"><span class="glyphicon glyphicon-plus"></span> Applications</a></li>';
          }
        ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
          if(isset($_SESSION['Username']))
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['Name'].' '.$_SESSION['Surname'].'</a></li>';
          else
            echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
          if(isset($_SESSION['Username']))
            echo '<li><a href="index.php?logout=true"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
          else
            echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
        ?>
      </ul>
    </div>
  </div>
</nav>
