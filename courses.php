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
	<title>课程帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
  $query = "SELECT course.ID, course.Name, Credit, teacher.Name as TeacherName, teacher.Surname as TeacherSurname,
	          teacher.ID as TeacherID, Duration, NumberOfLessons, location.Name as Location, Semester, Year, Level,
						location.ID as LocationID
	          FROM course
						LEFT JOIN teacher ON course.Teacher=teacher.ID
						LEFT JOIN location ON course.Location=location.ID
						ORDER BY course.ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center">Courses List</h1>
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
        echo "</table>";
      ?>
			<a href="form_course.php?insert=true" style="margin-top: 1%" class="btn btn-default" role="button">Add new course</a>
		</div>
</body>
</html>
