<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
	<meta name="description" content="Padova Confucius Institute Database"/>
	<meta name="keywords" content="chinese,language,confucius,database"/>
	<meta name="author" content="Davide Liu"/>
	<meta name="title" content="帕多瓦孔子学院数据库"/>
	<meta name="language" content="english en"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css" media="all"/>
	<script type="text/javascript" src="script.js" ></script>
	<link rel="icon" type="image/png" href="Images/confucius-logo-96.png"/>
	<title>老师登记帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
		require_once "DBconnector.php";
	?>

  <?php
	//error_reporting(0);
	$connectionError=false;
  $usedEmail=false;
	if((isset($_POST["email"])&&isset($_POST["name"])&&isset($_POST["surname"])&&isset($_POST["position"]))||(isset($_GET["delete"]))){
		  //cleaning the input
			$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
      $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
      $surname = htmlspecialchars($_POST["surname"], ENT_QUOTES, "UTF-8");
      $position = htmlspecialchars($_POST["position"], ENT_QUOTES, "UTF-8");
      $id;
      if(isset($_GET["id"]))
        $id = $_GET["id"];
			//connecting to db
			$myDb = new DbConnector();
			$myDb->openDBConnection();
			if($myDb->connected)
			{
        if(isset($_GET["delete"])&&$_GET["delete"]==="true"){
          $result = $myDb->doQuery("DELETE from teacher where ID='".$id."'");
          echo $id;
          header("location: teachers.php");
          die();
        }
        $result = $myDb->doQuery("SELECT Email from teacher where Email='".$email."' and ID<>'".$id."'");
        if($result->num_rows>0)
          $usedEmail=true;
        else
        {
          //ALTER TABLE tablename AUTO_INCREMENT = 1 : reset de autoindex
          if(isset($_GET["insert"])&&$_GET["insert"]=="true")
  				    $result = $myDb->doQuery("INSERT into teacher values ('$name','$surname','$email','','$position',DEFAULT)");//excecute query
          if(isset($_GET["update"])&&$_GET["update"]==="true")
              $result = $myDb->doQuery("UPDATE teacher SET Email='$email', Name = '$name', Surname = '$surname', Position = '$position'
                                        WHERE ID='$id'");//excecute query
          header("location: teachers.php");
          die();
        }
			}
			else
				$connectionError=true;
			$myDb->disconnect();
		}
	?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
        <?php
          if(isset($_GET["insert"])&&$_GET["insert"]==="true")
				    echo '<h1 class="text-center">Teacher Register Form</h1>';
          if(isset($_GET["update"])&&$_GET["update"]==="true"){
				    echo '<h1 class="text-center">Teacher Update Form</h1>';
            if(!isset($_POST['name'])&&!isset($_POST['surname'])&&!isset($_POST['email'])&&!isset($_POST['position'])){
              $_POST['name'] = $_GET['name'];
              $_POST['surname'] = $_GET['surname'];
              $_POST['email'] = $_GET['email'];
              $_POST['position'] = $_GET['position'];
            }
          }
        ?>
				<form action="" method="post">
				  <div class="form-group">
				    <label for="name">Name:</label>
				    <input type="text" class="form-control" id="name" name="name" maxlength="50"
						<?php if(isset($_POST['name']))echo 'value="'.$_POST['name'].'"'?> required="">
            <label for="surname">Surname:</label>
				    <input type="text" class="form-control" id="surname" name="surname" maxlength="50"
						<?php if(isset($_POST['surname']))echo 'value="'.$_POST['surname'].'"'?> required="">
            <label for="email">Email address:</label>
				    <input type="email" class="form-control" id="email" name="email" maxlength="50"
						<?php if(isset($_POST['email']))echo 'value="'.$_POST['email'].'"'?> required="">
            <label for="position">Position:</label>
    				<select class="form-control" id="position" name="position">
    					<option value="Headquarter" <?php if((isset($_POST['position'])&&$_POST['position']=='Headquarter')||(!isset($_POST['position']))){echo "selected='selected'";}?>>Headquarter</option>
    					<option value="Local" <?php if(isset($_POST['position'])&&$_POST['position']=='Local'){echo "selected='selected'";}?>>Local</option>
    				</select>
				  </div>
					<?php if($connectionError) echo '</br><div class="alert alert-danger">Could not connect to database!</div>' ?>
					<?php if($usedEmail) echo '<div class="alert alert-danger">Email already in use!</div>' ?>
          <?php
            if(isset($_GET["insert"])&&$_GET["insert"]==="true")
              echo '<button type="submit" class="btn btn-default">Insert</button>';
            if(isset($_GET["update"])&&$_GET["update"]==="true"){
              echo '<button type="submit" class="btn btn-default">Update</button>';
              echo '<a href="form_teacher.php?delete=true&id='.$_GET["id"].'" style="float: right" class="btn btn-danger" role="button">Delete</a>';
            }
          ?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
