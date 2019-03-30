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
	<title>申请学生帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
	$currentsemester=1;
	if(date('m')<8)$currentsemester=2;
  $query = "SELECT student.ID, student.Name, Surname, BirthDate, Occupation, MobilePhone, Telephone, Email, Gender,
	          count(student.ID) as NumberOfCourses
	          FROM student
						LEFT JOIN student_course ON student_course.Student=student.ID
						LEFT JOIN course ON course.ID=student_course.Course
            GROUP BY student.ID ORDER BY student.ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center">New student applications</h1>
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
									<th scope="col" class="text-center">Courses</th>
                  <th scope="col">Name</th>
                  <th scope="col">Surname</th>
                  <th scope="col">Age</th>
                  <th scope="col">Occupation</th>
                  <th scope="col">Mobile Phone</th>
                  <th scope="col">Telephone</th>
                  <th scope="col">Email</th>
                </tr>';
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
					$numberofpresentcourses[$i] = $row["NumberOfCourses"];
          echo '<tr>
                <td class="text-center"><a href="form_student.php?update=true&id='.$id[$i].'
								&name='.$name[$i].'&surname='.$surname[$i].'&email='.$email[$i].'&occupation='.$occupation[$i].'&mobilephone='.$mobilephone[$i].'&telephone='.$telephone[$i].'&gender='.$gender[$i].'&birthdate='.$stringbirthdate[$i].'">
								<span class="glyphicon glyphicon-edit"></span></a></td>
								<td class="text-center"><a href="student_courses.php?id='.$id[$i].'&studentname='.$name[$i].'
								&studentsurname='.$surname[$i].'">'.$numberofpresentcourses[$i].' '.'<span class="glyphicon glyphicon-new-window"></span>
								</a></td>
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
      ?>
      <a href="form_student.php?insert=true" style="margin-top: 1%" class="btn btn-default" role="button">Add new student</a>
    </div>
</body>
</html>
