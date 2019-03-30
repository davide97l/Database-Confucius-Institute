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
	<title>地方登记帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
		require_once "DBconnector.php";
	?>

  <?php
	//error_reporting(0);
	$connectionError=false;
	if(isset($_POST["name"])||isset($_GET["delete"])){
		  //cleaning the input
      $name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
      $id;
      if(isset($_GET["id"]))
        $id = $_GET["id"];
			//connecting to db
			$myDb = new DbConnector();
			$myDb->openDBConnection();
			if($myDb->connected)
			{
        if(isset($_GET["delete"])&&$_GET["delete"]==="true"){
          $result = $myDb->doQuery("DELETE from location where ID='".$id."'");
          echo $id;
          header("location: locations.php");
          die();
        }
        //ALTER TABLE tablename AUTO_INCREMENT = 1 : reset de autoindex
        if(isset($_GET["insert"])&&$_GET["insert"]=="true")
				    $result = $myDb->doQuery("INSERT into location values ('$name',DEFAULT)");//excecute query
        if(isset($_GET["update"])&&$_GET["update"]=="true")
            $result = $myDb->doQuery("UPDATE location SET Name='$name'
                                      WHERE ID='$id'");//excecute query
        header("location: locations.php");
        die();
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
				    echo '<h1 class="text-center">Location Register Form</h1>';
          if(isset($_GET["update"])&&$_GET["update"]==="true"){
				    echo '<h1 class="text-center">Location Update Form</h1>';
            if(!isset($_POST['name'])){
              $_POST['name'] = $_GET['name'];
            }
          }
        ?>
				<form action="" method="post">
				  <div class="form-group">
				    <label for="name">Name:</label>
				    <input type="text" class="form-control" id="name" name="name" maxlength="100"
						<?php if(isset($_POST['name']))echo 'value="'.$_POST['name'].'"'?> required="">
				  </div>
					<?php if($connectionError) echo '</br><div class="alert alert-danger">Could not connect to database!</div>' ?>
          <?php
            if(isset($_GET["insert"])&&$_GET["insert"]==="true")
              echo '<button type="submit" class="btn btn-default">Insert</button>';
            if(isset($_GET["update"])&&$_GET["update"]==="true"){
              echo '<button type="submit" class="btn btn-default">Update</button>';
              echo '<a href="form_location.php?delete=true&id='.$_GET["id"].'" style="float: right" class="btn btn-danger" role="button">Delete</a>';
            }
          ?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
