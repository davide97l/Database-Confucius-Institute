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
	$currentsemester=1;
	if(date('m')<8)$currentsemester=2;
  $occupation = "AND 1=1";
	$age = "AND 1=1";
	$location = "AND 1=1";
	$level = "AND 1=1";
	$teacher = "AND 1=1";
	$credited = "AND 1=1";
	$year = "AND 1=1";
	$semester = "AND 1=1";
  if(isset($_GET['occupation'])){
    if($_GET['occupation'] === "primary")
      $occupation = "AND occupation='Primary School'";
    if($_GET['occupation'] === "middle")
      $occupation = "AND occupation='Middle School'";
    if($_GET['occupation'] === "high")
      $occupation = "AND occupation='High School'";
    if($_GET['occupation'] === "university")
      $occupation = "AND occupation='University'";
    if($_GET['occupation'] === "worker")
      $occupation = "AND occupation='Worker'";
    if($_GET['occupation'] === "other")
      $occupation = "AND occupation='Other'";
  }
	if(isset($_GET['age'])){
    if($_GET['age'] === "underaged")
      $age = "AND year(CURRENT_TIMESTAMP) - year(BirthDate) < 18";
		if($_GET['age'] === "adult")
			$age = "AND year(CURRENT_TIMESTAMP) - year(BirthDate) >= 18";
  }
	if(isset($_GET['locationID'])&&$_GET['locationID']!="all"){
		$locationID = $_GET['locationID'];
		$location = "AND course.Location=$locationID";
	}
	if(isset($_GET['level'])&&$_GET['level']!="All"){
		$levelname = $_GET['level'];
		$level = "AND course.Level='$levelname'";
	}
	if(isset($_GET['teacherID'])&&$_GET['teacherID']!="all"){
		$teacherID = $_GET['teacherID'];
		$teacher = "AND course.Teacher=$teacherID";
	}
	if(isset($_GET['credited'])&&$_GET['credited']!="all"){
		$iscredited = $_GET['credited'];
		$credited = "AND course.Credit='$iscredited'";
	}
	if(isset($_GET['year'])&&$_GET['year']!="All"){
		$numyear = $_GET['year'];
		$year = "AND course.Year='$numyear'";
	}
	if(!isset($_GET['year'])){
		$year = "AND course.Year= year(CURRENT_TIMESTAMP)";
	}
	if(isset($_GET['semester'])&&$_GET['semester']!="all"){
		$numsemester = $_GET['semester'];
		$semester = "AND course.Semester=$numsemester";
	}
	if(!isset($_GET['semester'])){
		$semester = "AND course.Semester=$currentsemester";
	}
  $query = "SELECT student.ID, student.Name, Surname, BirthDate, Occupation, MobilePhone, Telephone, Email, Gender,
	          count(student.ID) as NumberOfCourses
	          FROM student
						LEFT JOIN student_course ON student_course.Student=student.ID
						LEFT JOIN course ON course.ID=student_course.Course
						WHERE 1=1 $occupation $age $location $level $teacher $credited $year $semester
            GROUP BY student.ID ORDER BY student.ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
      <form>
        <div class="form-group row">
          <div class="col-md-9 col-md-offset-1">
            <label for="occupation">Filter by occupation:</label>
            <select class="form-control" id="occupation" name="occupation" onchange="this.form.submit()">
              <option value="all" <?php if((isset($_GET['occupation'])&&$_GET['occupation']=='all')||(!isset($_GET['occupation']))){echo "selected='selected'";}?>>All</option>
              <option value="primary" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='primary'){echo "selected='selected'";}?>>Primary school</option>
              <option value="middle" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='middle'){echo "selected='selected'";}?>>Middle school</option>
              <option value="high" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='high'){echo "selected='selected'";}?>>High school</option>
              <option value="university" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='university'){echo "selected='selected'";}?>>University</option>
              <option value="worker" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='worker'){echo "selected='selected'";}?>>Worker</option>
              <option value="other" <?php if(isset($_GET['occupation'])&&$_GET['occupation']=='other'){echo "selected='selected'";}?>>Other</option>
            </select>
            <label for="age">Filter by age:</label>
            <select class="form-control" id="age" name="age" onchange='this.form.submit()'>
              <option value="all" <?php if((isset($_GET['age'])&&$_GET['age']=='all')||(!isset($_GET['age']))){echo "selected='selected'";}?>>All</option>
              <option value="underaged" <?php if(isset($_GET['age'])&&$_GET['age']=='underaged'){echo "selected='selected'";}?>>Underaged</option>
              <option value="adult" <?php if(isset($_GET['age'])&&$_GET['age']=='adult'){echo "selected='selected'";}?>>Adult</option>
            </select>
						<label for="credited">Filter by credits:</label>
            <select class="form-control" id="credited" name="credited" onchange='this.form.submit()'>
              <option value="all" <?php if((isset($_GET['credited'])&&$_GET['credited']=='all')||(!isset($_GET['credited']))){echo "selected='selected'";}?>>All</option>
              <option value="Yes" <?php if(isset($_GET['credited'])&&$_GET['credited']=='Yes'){echo "selected='selected'";}?>>Credited</option>
              <option value="No" <?php if(isset($_GET['credited'])&&$_GET['credited']=='No'){echo "selected='selected'";}?>>Uncredited</option>
            </select>
						<?php
						$locationlist = $myDb->doQuery("SELECT ID, Name from location");
						$locationid=array($locationlist->num_rows+1);
						$location=array($locationlist->num_rows+1);
						echo '<label for="locationID">Filter by location:</label>
									<select class="form-control" id="locationID" name="locationID" onchange="this.form.submit()">';
						for ($i = 0; $i < $locationlist->num_rows+1; $i++) {
							if($i==0){
								$locationid[$i] = "all";
			          $location[$i] = "All";
							}
							else{
			          $row = $locationlist->fetch_assoc();
			          $locationid[$i] = $row["ID"];
			          $location[$i] = $row["Name"];
							}
							echo '<option value="'.$locationid[$i].'"';
							if((isset($_GET['locationID'])&&$_GET['locationID']==$locationid[$i])||(!isset($_GET['locationID'])&&$i==0)){echo "selected='selected'";}
							echo '>'.$location[$i].'</option>';
						}
						echo "</select>";
						$teacherlist = $myDb->doQuery("SELECT ID, Name, Surname from teacher");
						$teacherid=array($teacherlist->num_rows);
						$teacher=array($teacherlist->num_rows);
						echo '<label for="teacherID">Filter by teacher:</label>
									<select class="form-control" id="teacherID" name="teacherID" onchange="this.form.submit()">';
						$teacherlist->fetch_assoc();
						for ($i = 0; $i < $teacherlist->num_rows; $i++) {
							if($i==0){
								$teacherid[$i] = "all";
			          $teacher[$i] = "All";
							}
							else{
			          $row = $teacherlist->fetch_assoc();
			          $teacherid[$i] = $row["ID"];
			          $teacher[$i] = $row["Name"].' '.$row["Surname"];
							}
							echo '<option value="'.$teacherid[$i].'"';
							if((isset($_GET['teacherID'])&&$_GET['teacherID']==$teacherid[$i])||(!isset($_GET['teacherID'])&&$i==0)){echo "selected='selected'";}
							echo '>'.$teacher[$i].'</option>';
						}
						echo "</select>";
						$level=array("All","A1.1","A1.2","A2.1","A2.2","B1.1","B1.2","B2.1","B2.2","C1.1","C1.2","C2.1","C2.2");
						echo '<label for="level">Filter by level:</label>
									<select class="form-control" id="level" name="level" onchange="this.form.submit()">';
						for ($i = 0; $i < 13 ; $i++) {
							echo '<option value="'.$level[$i].'"';
							if((isset($_GET['level'])&&$_GET['level']==$level[$i])||(!isset($_GET['level'])&&$i==0)){echo "selected='selected'";}
							echo '>'.$level[$i].'</option>';
						}
						echo '</select>';
						$yearlist = $myDb->doQuery("SELECT DISTINCT Year from course");
						$year=array($yearlist->num_rows+1);
						echo '<label for="year">Filter by year:</label>
									<select class="form-control" id="year" name="year" onchange="this.form.submit()">';
						for ($i = 0; $i < $yearlist->num_rows+1; $i++) {
							if($i==0){
			          $year[$i] = "All";
							}
							else{
			          $row = $yearlist->fetch_assoc();
			          $year[$i] = $row["Year"];
							}
							echo '<option value="'.$year[$i].'"';
							if((isset($_GET['year'])&&$_GET['year']==$year[$i])||(!isset($_GET['year'])&&$year[$i]==date("Y"))){echo "selected='selected'";}
							echo '>'.$year[$i].'</option>';
						}
						echo "</select>";
						?>
						<label for="semester">Filter by semester:</label>
            <select class="form-control" id="semester" name="semester" onchange='this.form.submit()'>
              <option value="all" <?php if((isset($_GET['semester'])&&$_GET['semester']=='all')){echo "selected='selected'";}?>>All</option>
              <option value="1" <?php if((isset($_GET['semester'])&&$_GET['semester']=='1')||(!isset($_GET['semester'])&&$currentsemester==1)){echo "selected='selected'";}?>>First</option>
              <option value="2" <?php if((isset($_GET['semester'])&&$_GET['semester']=='2')||(!isset($_GET['semester'])&&$currentsemester==2)){echo "selected='selected'";}?>>Second</option>
            </select>
            <?php echo "<h5 style='font-weight: 700'>Result: $result->num_rows students</h5>"; ?>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-8">
      <h1 class="text-center">Students List</h1>
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
				$numberofpresentcourses=array($result->num_rows);
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
					/*$query = "SELECT * FROM student
										JOIN student_course ON student_course.Student=student.ID
										JOIN course ON student_course.Course=course.ID
										WHERE course.Year=year(CURRENT_TIMESTAMP) AND student.ID=$id[$i] AND course.Semester='$currentsemester'";*/
					//$result2 = $myDb->doQuery($query);
					//$numberofpresentcourses[$i] = $result2->num_rows;
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
