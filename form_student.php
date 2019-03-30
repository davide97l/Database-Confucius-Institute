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
	<!-- Bootstrap Date-Picker Plugin -->
	<link rel="stylesheet" type="text/css" href="style/style.css" media="all"/>
	<script type="text/javascript" src="script.js" ></script>
	<link rel="icon" type="image/png" href="Images/confucius-logo-96.png"/>
	<title>学生登记帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
		require_once "DBconnector.php";
	?>

	<?php
	error_reporting(0);
	$connectionError=false;
	if((isset($_POST["name"])&&isset($_POST["surname"])&&isset($_POST["occupation"])
	    &&isset($_POST["gender"])&&isset($_POST["mobilephone"])&&isset($_POST["birthdate"]))
			||(isset($_GET["delete"]))){
			//setting optional fields
			if(!isset($_POST["telephone"]))
				$_POST["telephone"]='';
			//cleaning the input
			$email = htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8");
			$name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
			$surname = htmlspecialchars($_POST["surname"], ENT_QUOTES, "UTF-8");
			$occupation = htmlspecialchars($_POST["occupation"], ENT_QUOTES, "UTF-8");
			$gender = htmlspecialchars($_POST["gender"], ENT_QUOTES, "UTF-8");
			$mobilephone = htmlspecialchars($_POST["mobilephone"], ENT_QUOTES, "UTF-8");
			$telephone = htmlspecialchars($_POST["telephone"], ENT_QUOTES, "UTF-8");
			$birthdate = htmlspecialchars($_POST["birthdate"], ENT_QUOTES, "UTF-8");
			$birthdate = date("Y-m-d", strtotime($birthdate));
			$id;
			if(isset($_GET["id"]))
				$id = $_GET["id"];
			//connecting to db
			$myDb = new DbConnector();
			$myDb->openDBConnection();
			if($myDb->connected)
			{
				if(isset($_GET["delete"])&&$_GET["delete"]==="true"){
					$result = $myDb->doQuery("DELETE from student where ID='".$id."'");
					echo $id;
					header("location: students.php");
					die();
				}
				//ALTER TABLE tablename AUTO_INCREMENT = 1 : reset de autoindex
				if(isset($_GET["insert"])&&$_GET["insert"]==="true")
						$result = $myDb->doQuery("INSERT into student values ('$name','$surname','$occupation','$gender','$mobilephone',
							                       '$telephone','$email','$birthdate', DEFAULT)");//excecute query
				if(isset($_GET["update"])&&$_GET["update"]==="true")
						$result = $myDb->doQuery("UPDATE student SET Name = '$name', Surname = '$surname', Occupation = '$occupation',
							                        Gender = '$gender', MobilePhone = '$mobilephone', Telephone = '$telephone', Email = '$email',
																			BirthDate = '$birthdate'
																			WHERE ID='$id'");//excecute query
				header("location: students.php");
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
						echo '<h1 class="text-center">Student Register Form</h1>';
					if(isset($_GET["update"])&&$_GET["update"]==="true"){
						echo '<h1 class="text-center">Student Update Form</h1>';
						if(!isset($_POST['name'])&&!isset($_POST['surname'])&&!isset($_POST['email'])&&!isset($_POST['occupation'])
					     &&!isset($_POST['gender'])&&!isset($_POST['mobilephone'])&&!isset($_POST['telephone'])&&!isset($_POST['birthdate'])){
							$_POST['name'] = $_GET['name'];
							$_POST['surname'] = $_GET['surname'];
							$_POST['email'] = $_GET['email'];
							$_POST['occupation'] = $_GET['occupation'];
							$_POST['mobilephone'] = $_GET['mobilephone'];
							$_POST['telephone'] = $_GET['telephone'];
							$_POST['birthdate'] = $_GET['birthdate'];
							$_POST['gender'] = $_GET['gender'];
							$originalDate = $_POST['birthdate'];
							$_POST['birthdate'] = date("Y-m-d", strtotime($originalDate));
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
						<label for="mobilephone">Mobile Phone:</label>
						<input type="tel" class="form-control" id="mobilephone" name="mobilephone" maxlength="30"
						<?php if(isset($_POST['mobilephone']))echo 'value="'.$_POST['mobilephone'].'"'?> required="">
						<label for="telephone">Telephone (Optional):</label>
						<input type="tel" class="form-control" id="telephone" name="telephone" maxlength="30"
						<?php if(isset($_POST['telephone']))echo 'value="'.$_POST['telephone'].'"'?>>
						<label for="occupation">Occupation:</label>
						<select class="form-control" id="occupation" name="occupation">
							<option value="Primary School" <?php if((isset($_GET['occupation'])&&$_GET['occupation']=='Primary School')||(!isset($_GET['occupation']))){echo "selected='selected'";}?>>Primary School</option>
							<option value="Middle School" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='Middle School'){echo "selected='selected'";}?>>Middle School</option>
							<option value="High School" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='High School'){echo "selected='selected'";}?>>High School</option>
							<option value="University" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='University'){echo "selected='selected'";}?>>University</option>
							<option value="Worker" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='Worker'){echo "selected='selected'";}?>>Worker</option>
							<option value="Other" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='Other'){echo "selected='selected'";}?>>Other</option>
						</select>
						<label for="birthdate">Date of birth:</label>
						<input type="date" class="form-control" id="birthdate" name="birthdate" min="1900-01-01" max="2100-01-01"
						<?php if(isset($_POST['birthdate']))echo 'value="'.$_POST["birthdate"].'"'?> required=""/>
						<label for="gender">Gender:</label>
						<select class="form-control" id="gender" name="gender">
							<option value="Male" <?php if((isset($_POST['gender'])&&$_POST['gender']=='Male')||(!isset($_POST['gender']))){echo "selected='selected'";}?>>Male</option>
							<option value="Female" <?php if(isset($_POST['gender'])&&$_POST['gender']=='Female'){echo "selected='selected'";}?>>Female</option>
						</select>
					</div>
					<?php if($connectionError) echo '</br><div class="alert alert-danger">Could not connect to database!</div>' ?>
					<?php
						if(isset($_GET["insert"])&&$_GET["insert"]==="true")
							echo '<button type="submit" class="btn btn-default">Insert</button>';
						if(isset($_GET["update"])&&$_GET["update"]==="true"){
							echo '<button type="submit" class="btn btn-default">Update</button>';
							echo '<a href="form_student.php?delete=true&id='.$_GET["id"].'" style="float: right" class="btn btn-danger" role="button">Delete</a>';
						}
					?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
