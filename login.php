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
	<title>登记帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
		require_once "DBconnector.php";
	?>

  <?php
	error_reporting(0);
	$connectionError=$invalidPwd=$invalidEml=false;
	if(isset($_POST["pwd"])&&isset($_POST["eml"])){
		  //cleaning the input
			$pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, "UTF-8");
			$eml = htmlspecialchars($_POST["eml"], ENT_QUOTES, "UTF-8");
			//connecting to db
			$myDb = new DbConnector();
			$myDb->openDBConnection();
			if($myDb->connected)
			{
				$result = $myDb->doQuery("select * from teacher where Email='".$eml."'");//excecute query
				if(isset($eml) && !is_null($result) && $result->num_rows === 1)
				{
					$row = $result->fetch_assoc();
					if(password_verify($pwd,$row["Password"]))
					{
						$_SESSION["Username"] = $eml;
						$_SESSION["Name"] = $row["Name"];
						$_SESSION["Surname"] = $row["Surname"];
						header("location: index.php");
						die();
					}
					else
						$invalidPwd=true;
				}
				else
					$invalidEml=true;
			}
			else
				$connectionError=true;
			$myDb->disconnect();
		}
	?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<h1 class="text-center">Teacher Login Form</h1>
				<form action="" method="post">
				  <div class="form-group">
				    <label for="email">Email address:</label>
				    <input type="email" class="form-control" id="email" name="eml" maxlength="50"
						<?php if(isset($_POST['eml']))echo 'value="'.$_POST['eml'].'"'?>>
				  </div>
				  <div class="form-group">
				    <label for="pwd">Password:</label>
				    <input type="password" class="form-control" id="pwd" name="pwd" maxlength="50">
				  </div>
					<?php if($connectionError) echo '</br><div class="alert alert-danger">Could not connect to database!</div>' ?>
					<?php if($invalidEml) echo '<div class="alert alert-danger">Invalid email!</div>' ?>
					<?php if($invalidPwd) echo '</br><div class="alert alert-danger">Invalid password!</div>' ?>
				  <button type="submit" class="btn btn-default">Login</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
