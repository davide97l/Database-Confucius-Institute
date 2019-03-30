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
	<title>课程登记帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
		require_once "DBconnector.php";
	?>

	<?php
	error_reporting(0);
	$connectionError=false;
	if((isset($_POST["name"])&&isset($_POST["credit"])&&isset($_POST["teacherID"])
	    &&isset($_POST["duration"])&&isset($_POST["numberoflessons"])&&isset($_POST["locationID"])
			&&isset($_POST["semester"])&&isset($_POST["year"])&&isset($_POST["level"]))
			||(isset($_GET["delete"]))){
			//cleaning the input
			$credit = htmlspecialchars($_POST["credit"], ENT_QUOTES, "UTF-8");
			$name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
			$teacherID = htmlspecialchars($_POST["teacherID"], ENT_QUOTES, "UTF-8");
			$duration = htmlspecialchars($_POST["duration"], ENT_QUOTES, "UTF-8");
			$numberoflessons = htmlspecialchars($_POST["numberoflessons"], ENT_QUOTES, "UTF-8");
			$locationID = htmlspecialchars($_POST["locationID"], ENT_QUOTES, "UTF-8");
			$semester = htmlspecialchars($_POST["semester"], ENT_QUOTES, "UTF-8");
			$year = htmlspecialchars($_POST["year"], ENT_QUOTES, "UTF-8");
			$level = htmlspecialchars($_POST["level"], ENT_QUOTES, "UTF-8");
			$id;
			if(isset($_GET["id"]))
				$id = $_GET["id"];
			//connecting to db
			$myDb = new DbConnector();
			$myDb->openDBConnection();
			if($myDb->connected)
			{
				if(isset($_GET["delete"])&&$_GET["delete"]==="true"){
					$result = $myDb->doQuery("DELETE from course where ID='".$id."'");
					echo $id;
					header("location: courses.php");
					die();
				}
				//ALTER TABLE tablename AUTO_INCREMENT = 1 : reset autoindex
				if(isset($_GET["insert"])&&$_GET["insert"]==="true")
						$result = $myDb->doQuery("INSERT into course values ('$name','$credit','$teacherID','$duration','$numberoflessons',
							                       '$locationID','$semester','$year','$level', DEFAULT)");//excecute query
				if(isset($_GET["update"])&&$_GET["update"]==="true")
						$result = $myDb->doQuery("UPDATE course SET Name = '$name', Credit = '$credit', Teacher = '$teacherID',
							                        Duration = '$duration', NumberOfLessons = '$numberoflessons', Location = '$locationID', Semester = '$semester',
																			Year = '$year', Level = '$level'
																			WHERE ID='$id'");//excecute query
				header("location: courses.php");
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
						echo '<h1 class="text-center">Course Register Form</h1>';
					if(isset($_GET["update"])&&$_GET["update"]==="true"){
						echo '<h1 class="text-center">Course Update Form</h1>';
						if(!isset($_POST['name'])&&!isset($_POST['credit'])&&!isset($_POST['teacherID'])&&!isset($_POST['duration'])
					     &&!isset($_POST['numberoflessons'])&&!isset($_POST['locationID'])&&!isset($_POST['semester'])&&!isset($_POST['year'])
						   &&!isset($_POST['level'])){
							$_POST['name'] = $_GET['name'];
							$_POST['credit'] = $_GET['credit'];
							$_POST['teacherID'] = $_GET['teacherID'];
							$_POST['duration'] = $_GET['duration'];
							$_POST['numberoflessons'] = $_GET['numberoflessons'];
							$_POST['locationID'] = $_GET['locationID'];
							$_POST['semester'] = $_GET['semester'];
							$_POST['year'] = $_GET['year'];
							$_POST['level'] = $_GET['level'];
						}
					}
				?>
				<form action="" method="post">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" class="form-control" id="name" name="name" maxlength="100"
						<?php if(isset($_POST['name']))echo 'value="'.$_POST['name'].'"'?> required="">
						<label for="level">Level:</label>
						<select class="form-control" id="level" name="level">
							<option value="A1.1" <?php if((isset($_GET['level'])&&$_GET['level']=='A1.1')||(!isset($_GET['level']))){echo "selected='selected'";}?>>A1.1</option>
							<option value="A1.2" <?php if(isset($_GET['level'])&&$_GET['level']=='A1.2'){echo "selected='selected'";}?>>A1.2</option>
							<option value="A2.1" <?php if(isset($_GET['level'])&&$_GET['level']=='A2.1'){echo "selected='selected'";}?>>A2.1</option>
							<option value="A2.2" <?php if(isset($_GET['level'])&&$_GET['level']=='A2.2'){echo "selected='selected'";}?>>A2.2</option>
							<option value="B1.1" <?php if(isset($_GET['level'])&&$_GET['level']=='B1.1'){echo "selected='selected'";}?>>B1.1</option>
							<option value="B1.2" <?php if(isset($_GET['level'])&&$_GET['level']=='B1.2'){echo "selected='selected'";}?>>B1.2</option>
							<option value="B2.1" <?php if(isset($_GET['level'])&&$_GET['level']=='B2.1'){echo "selected='selected'";}?>>B2.1</option>
							<option value="B2.2" <?php if(isset($_GET['level'])&&$_GET['level']=='B2.2'){echo "selected='selected'";}?>>B2.2</option>
							<option value="C1.1" <?php if(isset($_GET['level'])&&$_GET['level']=='C1.1'){echo "selected='selected'";}?>>C1.1</option>
							<option value="C1.2" <?php if(isset($_GET['level'])&&$_GET['level']=='C1.2'){echo "selected='selected'";}?>>C1.2</option>
							<option value="C2.1" <?php if(isset($_GET['level'])&&$_GET['level']=='C2.1'){echo "selected='selected'";}?>>C2.1</option>
							<option value="C2.2" <?php if(isset($_GET['level'])&&$_GET['level']=='C2.2'){echo "selected='selected'";}?>>C2.2</option>
						</select>
						<!--choices for teachers and locations form-->
            <?php
						$myDb = new DbConnector();
						$myDb->openDBConnection();
						if($myDb->connected)
						{
							$result = $myDb->doQuery("SELECT ID, Name, Surname from teacher");
							$teacherid=array($result->num_rows);
			        $teacher=array($result->num_rows);
							echo '<label for="teacherID">Teacher:</label>
										<select class="form-control" id="teacherID" name="teacherID">';
							$result->fetch_assoc();//to exclude admin
							for ($i = 0; $i < $result->num_rows-1; $i++) {
			          $row = $result->fetch_assoc();
			          $teacherid[$i] = $row["ID"];
			          $teacher[$i] = $row["Name"].' '.$row["Surname"];
								echo '<option value="'.$teacherid[$i].'"';
								if((isset($_GET['teacherID'])&&$_GET['teacherID']==$teacherid[$i])||(!isset($_GET['teacherID'])&&$i==0)){echo "selected='selected'";}
								echo '>'.$teacher[$i].'</option>';
							}
							echo '</select>';
							$result = $myDb->doQuery("SELECT ID, Name from location");
							$locationid=array($result->num_rows);
			        $location=array($result->num_rows);
							echo '<label for="locationID">Location:</label>
										<select class="form-control" id="locationID" name="locationID">';
							for ($i = 0; $i < $result->num_rows; $i++) {
			          $row = $result->fetch_assoc();
			          $locationid[$i] = $row["ID"];
			          $location[$i] = $row["Name"];
								echo '<option value="'.$locationid[$i].'"';
								if((isset($_GET['locationID'])&&$_GET['locationID']==$locationid[$i])||(!isset($_GET['locationID'])&&$i==0)){echo "selected='selected'";}
								echo '>'.$location[$i].'</option>';
							}
							echo '</select>';
						}
						?>

						<label for="duration">Duration (Hours):</label>
						<input type="number" class="form-control" id="duration" name="duration" min="0" max="10000"
						<?php if(isset($_POST['duration']))echo 'value="'.$_POST['duration'].'"'?> required="">
						<label for="numberoflessons">Number of Lessons:</label>
						<input type="number" class="form-control" id="numberoflessons" name="numberoflessons" min="0" max="1000"
						<?php if(isset($_POST['numberoflessons']))echo 'value="'.$_POST['numberoflessons'].'"'?> required="">
						<label for="year">Year:</label>
						<input type="number" class="form-control" id="year" name="year" min="2000" max="3000"
						<?php if(isset($_POST['year']))echo 'value="'.$_POST['year'].'"'?> required="">
						<label for="semester">Semester:</label>
						<select class="form-control" id="semester" name="semester">
							<option value="1" <?php if((isset($_POST['semester'])&&$_POST['semester']=='1')||(!isset($_POST['semester']))){echo "selected='selected'";}?>>First Semester</option>
							<option value="2" <?php if(isset($_POST['semester'])&&$_POST['semester']=='2'){echo "selected='selected'";}?>>Second Semester</option>
						</select>
						<label for="credit">Has credits:</label>
						<select class="form-control" id="credit" name="credit">
							<option value="Yes" <?php if((isset($_POST['credit'])&&$_POST['credit']=='Yes')||(!isset($_POST['credit']))){echo "selected='selected'";}?>>Yes</option>
							<option value="No" <?php if(isset($_POST['credit'])&&$_POST['credit']=='No'){echo "selected='selected'";}?>>No</option>
						</select>
					</div>
					<?php if($connectionError) echo '</br><div class="alert alert-danger">Could not connect to database!</div>' ?>
					<?php
						if(isset($_GET["insert"])&&$_GET["insert"]==="true")
							echo '<button type="submit" class="btn btn-default">Insert</button>';
						if(isset($_GET["update"])&&$_GET["update"]==="true"){
							echo '<button type="submit" class="btn btn-default">Update</button>';
							echo '<a href="form_course.php?delete=true&id='.$_GET["id"].'" style="float: right" class="btn btn-danger" role="button">Delete</a>';
						}
					?>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
