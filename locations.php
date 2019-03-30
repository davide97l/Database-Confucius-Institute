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
	<title>地方帕多瓦孔子学院数据库</title>
</head>

<body>
	<?php
		require_once "navbar.php";
    require_once "DBconnector.php";
	?>
  <?php
  $myDb= new DbConnector();
  $myDb->openDBConnection();
  $query = "SELECT Name, ID FROM location ORDER BY ID";
  $result = $myDb->doQuery($query);
  ?>
  <div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
      <h1 class="text-center">Locations List</h1>
      <?php
        $id=array($result->num_rows);
        $name=array($result->num_rows);
        echo '<table summary="In this table you can find a list of the locations">
                <tr>
                  <th scope="col" class="text-center">Edit</th>
                  <th scope="col">Name</th>
                </tr>';
				for ($i = 0; $i < $result->num_rows; $i++) {
          $row = $result->fetch_assoc();
          $name[$i] = $row["Name"];
          $id[$i] = $row["ID"];
          echo '<tr>
                <td class="text-center"><a href="form_location.php?update=true&id='.$id[$i].'
								&name='.$name[$i].'">
								<span class="glyphicon glyphicon-edit"></span></a></td>
                <td>'.$name[$i].'</td>
                </tr>';
        }
        echo "</table>";
      ?>
		<a href="form_location.php?insert=true" style="margin-top: 1%" class="btn btn-default" role="button">Add new location</a>
		</div>
</body>
</html>
