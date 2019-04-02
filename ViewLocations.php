<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Location Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Info.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="main.js"></script>
</head>
<body>
<div style = "text-align: center;"class = "navbar">
<button type="button" onclick = "location.href = 'index.php'"/>HOME  </button>
    <button type="button" onclick = "location.href = 'Adduser.html'"/> ADD USER  </button>
    <button type="button" onclick = "location.href = 'Staff.php'"/> STAFF LOCATIONS </button>
   
        <button type="button" onclick = "location.href = 'UpdateDetails.html'"/>UPDATE DETAILS </button>
        <button type="button" onclick = "location.href = 'Changelocation.html'"/>CHANGE LOCATION </button>
        <button type="button" onclick = "location.href = 'ViewLocations.php'"/>STUDENT LOCATIONS  </button>
    
        <button type="button" onclick = "location.href = 'LastDay.html'"/> LAST 24 HOURS </button>
        <button type="button" onclick = "location.href = 'ByLocation.html'"/>LIST BY LOCATION </button>
        <button type="button" onclick = "location.href = 'Locationhistory.html'"/>LOCATION HISTORY</button>
</div>

<?php

    $serverName = "sql.rde.hull.ac.uk";  
    $connectionOptions = array("Database"=>"rde_555426");
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    $Fetch = "SELECT * FROM StudentFinder WHERE UserType LIKE 'Student'";
    $result = sqlsrv_query ($conn, $Fetch);
    $sql = sqlsrv_query($conn, $result);  

    echo "<div class = title>";
    echo "<h1> Student Locations <h1/>";
    echo "</div>";
    echo "<table border = 1>
    <tr>
    <th>Student ID</th>
    <th>First Name</th>
    <th>Surname</th>
    <th>Location</th>
    <th>Date</th>
    </tr>";
   

   while($row = sqlsrv_fetch_array($result))
     {    
        echo "<tr>";
        echo "<td>" . $row['StudentID'] . "</td>";
        echo "<td>" . $row['FirstName'] . "</td>";
        echo "<td>" . $row['Surname'] . "</td>";
        echo "<td>" . $row['LocationOfStudent'] . "</td>";
        echo "<td>" . $row['CurrentDate'] ->format('Y-m-d H:i:s') . "</td>";
        echo "</tr>" ;
          
    }
    echo "</table>";
    
    
    if (!$sql) {
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo $error['message'];
            }
        }
    } 
    sqlsrv_close($conn);


?>


</body>
<footer>James Duncan - Web Technologies Assignment 2018</footer>
</html>