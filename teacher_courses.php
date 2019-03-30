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
	<title>老师课程帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
  $id=$_GET["id"];
  //if there is a course to be added
  if(isset($_POST["addcourseID"])){
    $addcourseid=$_POST["addcourseID"];
    $query = "UPDATE course SET Teacher='$id' WHERE ID='$addcourseid'";
    $myDb->doQuery($query);
    unset($_POST["addcourseID"]);
  }
  //return the list of courses a student attended (also the ones in the past)
  $query = "SELECT course.ID, course.Name, Credit, teacher.Name as TeacherName, teacher.Surname as TeacherSurname,
	          teacher.ID as TeacherID, Duration, NumberOfLessons, location.Name as Location, Semester, Year, Level,
						location.ID as LocationID
	          FROM course
						JOIN teacher ON course.Teacher=teacher.ID
						JOIN location ON course.Location=location.ID
            WHERE course.Teacher='$id'
						ORDER BY course.ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center"><?php echo $_GET["teachername"].' '.$_GET["teachersurname"] ?></h1>
      <h2 class="text-center">Current semester teaching courses</h2>
      <?php
        $id=array($result->num_rows);
        $name=array($result->num_rows);
        $credit=array($result->num_rows);
        $teachername=array($result->num_rows);
				$teachersurame=array($result->num_rows);
				$teacherID=array($result->num_rows);
				$duration=array($result->num_rows);
				$numberoflessons=array($result->num_rows);
				$location=array($result->num_rows);
				$locationID=array($result->num_rows);
				$semester=array($result->num_rows);
				$year=array($result->num_rows);
				$level=array($result->num_rows);
        echo '<table summary="In this table you can find a list of the courses and their data">
                <tr>
                  <th scope="col" class="text-center">Edit</th>
									<th scope="col" class="text-center"">Details</th>
									<th scope="col">Level</th>
                  <th scope="col">Teacher</th>
                  <th scope="col">Location</th>
									<th scope="col" class="text-center">Semester</th>
									<th scope="col" class="text-center">Year</th>
									<th scope="col" class="text-center">Lessons</th>
									<th scope="col" class="text-center">Duration</th>
									<th scope="col" class="text-center">Credit</th>
                </tr>';
        $count=0;
        $currentsemester=1;
        if(date('m')<8)$currentsemester=2;
        for ($i = 0; $i < $result->num_rows; $i++) {
          $row = $result->fetch_assoc();
          $name[$i] = $row["Name"];
          $level[$i] = $row["Level"];
          $teachername[$i] = $row["TeacherName"];
					$teachersurname[$i] = $row["TeacherSurname"];
					$teacherID[$i] = $row["TeacherID"];
					$location[$i] = $row["Location"];
					$locationID[$i] = $row["LocationID"];
					$semester[$i] = $row["Semester"];
          $year[$i] = $row["Year"];
          $numberoflessons[$i] = $row["NumberOfLessons"];
					$duration[$i] = $row["Duration"];
					$credit[$i] = $row["Credit"];
          $id[$i] = $row["ID"];
          //ATTENTION: year x semester II comes before year x semester I
          if($year[$i]==date("Y")&&$semester[$i]==$currentsemester){
            $count++;
            echo '<tr>
                  <td class="text-center"><a href="form_course.php?update=true&id='.$id[$i].'
  								&name='.$name[$i].'&level='.$level[$i].'&teacherID='.$teacherID[$i].'&location='.$locationID[$i].'
  								&semester='.$semester[$i].'&year='.$year[$i].'&numberoflessons='.$numberoflessons[$i].'&duration='.$duration[$i].'
  								&credit='.$credit[$i].'">
  								<span class="glyphicon glyphicon-edit"></span></a></td>
  								<td class="text-center"><a href="detail_course.php?id='.$id[$i].'&coursename='.$name[$i].'">
  								<span class="glyphicon glyphicon-new-window"></span></a></td>
                  <td>'.$level[$i].'</td>
                  <td>'.$teachername[$i].' '.$teachersurname[$i].'</td>
                  <td>'.$location[$i].'</td>';
  				  if($semester[$i]==1)echo "<td class='text-center'>I</td>";
  				  else echo "<td class='text-center'>II</td>";
  					echo '<td class="text-center">'.$year[$i].'</td>
  								<td class="text-center">'.$numberoflessons[$i].'</td>
  								<td class="text-center">'.$duration[$i].'h</td>
  								<td class="text-center">'.$credit[$i].'</td>
                  </tr>';
          }
        }
        echo "</table>";
        echo "<h4 style='font-weight: 700'>Total courses: $count</h4>";
        if($myDb->connected)
        {
          $teacherid=$_GET['id'];
          $courseresult = $myDb->doQuery("SELECT ID, Name from course
                                          WHERE year=year(CURRENT_TIMESTAMP) AND
                                          Semester='$currentsemester' AND ID NOT IN (
                                          SELECT ID FROM course WHERE Teacher='$teacherid')");
          $courseid=array($courseresult->num_rows);
          $course=array($courseresult->num_rows);
          echo '<form action="" method="post">
                  <div class="form-group">';
          echo '<label for="addcourseID">Select a new course to add:</label>
                <select class="form-control" id="addcourseID" name="addcourseID">';
          for ($i = 0; $i < $courseresult->num_rows; $i++) {
            $row = $courseresult->fetch_assoc();
            $courseid[$i] = $row["ID"];
            $course[$i] = $row["Name"];
            echo '<option value="'.$courseid[$i].'"';
            echo '>'.$course[$i].'</option>';
          }
          echo '</select></div>';
          echo '<button type="submit" class="btn btn-default">Add Course</button></form>';
        }
      ?>
      <h2 class="text-center">Past courses</h2>
      <?php
        echo '<table summary="In this table you can find a list of the courses and their data">
                <tr>
                  <th scope="col" class="text-center">Edit</th>
									<th scope="col" class="text-center"">Details</th>
									<th scope="col">Level</th>
                  <th scope="col">Teacher</th>
                  <th scope="col">Location</th>
									<th scope="col" class="text-center">Semester</th>
									<th scope="col" class="text-center">Year</th>
									<th scope="col" class="text-center">Lessons</th>
									<th scope="col" class="text-center">Duration</th>
									<th scope="col" class="text-center">Credit</th>
                </tr>';
        $count=0;
        for ($i = 0; $i < $result->num_rows; $i++) {
          if($year[$i]<date("Y")||$semester[$i]!=$currentsemester){
            $count++;
            echo '<tr>
                  <td class="text-center"><a href="form_course.php?update=true&id='.$id[$i].'
  								&name='.$name[$i].'&level='.$level[$i].'&teacherID='.$teacherID[$i].'&location='.$locationID[$i].'
  								&semester='.$semester[$i].'&year='.$year[$i].'&numberoflessons='.$numberoflessons[$i].'&duration='.$duration[$i].'
  								&credit='.$credit[$i].'">
  								<span class="glyphicon glyphicon-edit"></span></a></td>
  								<td class="text-center"><a href="detail_course.php?id='.$id[$i].'&coursename='.$name[$i].'">
  								<span class="glyphicon glyphicon-new-window"></span></a></td>
                  <td>'.$level[$i].'</td>
                  <td>'.$teachername[$i].' '.$teachersurname[$i].'</td>
                  <td>'.$location[$i].'</td>';
  				  if($semester[$i]==1)echo "<td class='text-center'>I</td>";
  				  else echo "<td class='text-center'>II</td>";
  					echo '<td class="text-center">'.$year[$i].'</td>
  								<td class="text-center">'.$numberoflessons[$i].'</td>
  								<td class="text-center">'.$duration[$i].'h</td>
  								<td class="text-center">'.$credit[$i].'</td>
									</tr>';
          }
        }
        echo "</table>";
        echo "<h4 style='font-weight: 700'>Total courses: $count</h4>";
      ?>
		</div>
</body>
</html>
