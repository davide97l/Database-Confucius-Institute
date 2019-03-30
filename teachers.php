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
	<title>学生帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
  $query = "SELECT ID, Name, Surname, Email, Position FROM teacher ORDER BY ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center">Teachers List</h1>
      <?php
        $id=array($result->num_rows);
        $name=array($result->num_rows);
        $surname=array($result->num_rows);
        $email=array($result->num_rows);
				$position=array($result->num_rows);
				$numberofpresentcourses=array($result->num_rows);
        echo '<table summary="In this table you can find a list of the teachers and their data">
                <tr>
                  <th scope="col" class="text-center">Edit</th>
									<th scope="col" class="text-center">Courses</th>
                  <th scope="col">Name</th>
                  <th scope="col">Surname</th>
                  <th scope="col">Email</th>
									<th scope="col">Position</th>
                </tr>';
				$row = $result->fetch_assoc();//discard the first user (admin)
				$currentsemester=1;
				if(date('m')<8)$currentsemester=2;
        for ($i = 0; $i < $result->num_rows-1; $i++) {
          $row = $result->fetch_assoc();
          $name[$i] = $row["Name"];
          $surname[$i] = $row["Surname"];
          $email[$i] = $row["Email"];
					$position[$i] = $row["Position"];
          $id[$i] = $row["ID"];
					$query = "SELECT * FROM teacher
										JOIN course ON course.Teacher=teacher.ID
										WHERE course.Year=year(CURRENT_TIMESTAMP) AND teacher.ID=$id[$i] AND course.Semester='$currentsemester'";
					$result2 = $myDb->doQuery($query);
					$numberofpresentcourses[$i] = $result2->num_rows;
          echo '<tr>
                <td class="text-center"><a href="form_teacher.php?update=true&id='.$id[$i].'
								&name='.$name[$i].'&surname='.$surname[$i].'&email='.$email[$i].'&position='.$position[$i].'">
								<span class="glyphicon glyphicon-edit"></span></a></td>
								<td class="text-center"><a href="teacher_courses.php?id='.$id[$i].'&teachername='.$name[$i].'
								&teachersurname='.$surname[$i].'">'.$numberofpresentcourses[$i].' '.'<span class="glyphicon glyphicon-new-window"></span>
								</a></td>
                <td>'.$name[$i].'</td>
                <td>'.$surname[$i].'</td>
                <td>'.$email[$i].'</td>
								<td>'.$position[$i].'</td>
                </tr>';
        }
        echo "</table>";
      ?>
			<a href="form_teacher.php?insert=true" style="margin-top: 1%" class="btn btn-default" role="button">Add new teacher</a>
		</div>
</body>
</html>
