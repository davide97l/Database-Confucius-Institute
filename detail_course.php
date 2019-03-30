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
	<title>管理课程帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
	$id = $_GET["id"];
  $query = "SELECT student.ID as ID, student.Name as Name, student.Surname as Surname,
	          student.BirthDate as BirthDate, student.Occupation as Occupation,
	          student.MobilePhone as MobilePhone, student.Telephone as Telephone,
					  student.Email as Email, student.Gender as Gender
	          FROM student
						JOIN student_course ON student_course.Student=student.ID AND student_course.Course='$id'
						ORDER BY student.ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center"><?php echo $_GET["coursename"] ?></h1>
			<h2 class="text-center">Students List</h2>
			<?php
				$id=array($result->num_rows);
				$name=array($result->num_rows);
				$surname=array($result->num_rows);
				$age=array($result->num_rows);
				$occupation=array($result->num_rows);
				$mobilephone=array($result->num_rows);
				$telephone=array($result->num_rows);
				$email=array($result->num_rows);
				$gender=array($result->num_rows);
				$stringbirthdate=array($result->num_rows);
				echo '<table summary="In this table you can find a list of the students and their data">
								<tr>
									<th scope="col" class="text-center">Edit</th>
									<th scope="col">Name</th>
									<th scope="col">Surname</th>
									<th scope="col">Age</th>
									<th scope="col">Occupation</th>
									<th scope="col">Mobile Phone</th>
									<th scope="col">Telephone</th>
									<th scope="col">Email</th>
								</tr>';
				$i;
				for ($i = 0; $i < $result->num_rows; $i++) {
					$row = $result->fetch_assoc();
					$name[$i] = $row["Name"];
					$surname[$i] = $row["Surname"];
					$gender[$i] = $row["Gender"];
					$today = new DateTime();
					$birthdate = new DateTime($row["BirthDate"]);
					$interval = $today->diff($birthdate);
					$age[$i] = (int)$interval->format('%y years');
					$stringbirthdate[$i] = $row["BirthDate"];
					$occupation[$i] = $row["Occupation"];
					$mobilephone[$i] = $row["MobilePhone"];
					$telephone[$i] = $row["Telephone"];
					$email[$i] = $row["Email"];
					$id[$i] = $row["ID"];
					echo '<tr>
								<td class="text-center"><a href="form_student.php?update=true&id='.$id[$i].'
								&name='.$name[$i].'&surname='.$surname[$i].'&email='.$email[$i].'&occupation='.$occupation[$i].'&mobilephone='.$mobilephone[$i].'&telephone='.$telephone[$i].'&gender='.$gender[$i].'&birthdate='.$stringbirthdate[$i].'">
								<span class="glyphicon glyphicon-edit"></span></a></td>
								<td>'.$name[$i].'</td>
								<td>'.$surname[$i].'</td>
								<td>'.$age[$i].'</td>
								<td>'.$occupation[$i].'</td>
								<td>'.$mobilephone[$i].'</td>
								<td>'.$telephone[$i].'</td>
								<td>'.$email[$i].'</td>
								</tr>';
				}
				echo "</table>";
				echo "<h4 style='font-weight: 700'>Total students: $i</h4>";
			?>

		</div>
</body>
</html>
