<style>
<?php include 'info.css';?>
</style>
<?php

    try  

        { 
            $serverName = "sql.rde.hull.ac.uk";  
            $connectionOptions = array("Database"=>"rde_555426");
            $conn = sqlsrv_connect($serverName, $connectionOptions);

            $studentid = $_GET['Studentid'];

            $Fetch = "SELECT * FROM StudentFinder WHERE ? LIKE studentID AND UserType LIKE 'Student'";
            $params = array ($studentid);
            $result = sqlsrv_query ($conn, $Fetch, $params);
             
           
            

            echo "<div class = title>";
            echo "<h1> Results <h1/>";
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
        }  
        catch(Exception $e)
       {  
            echo("Error!");
       }  

?>






