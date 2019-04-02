


<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 try  
 {  
     $serverName = "sql.rde.hull.ac.uk";  
     $connectionOptions = array("Database"=>"rde_555426");
     $conn = sqlsrv_connect($serverName, $connectionOptions);

     $studentid = $_POST['Studentid1'];

     $FirstNamebase = "SELECT FirstName From Studentfinder WHERE StudentID LIKE '$studentid'";
     $Surnamebase = "SELECT Surname From Studentfinder WHERE StudentID LIKE '$studentid'";
     $Userbase =  "SELECT UserType From Studentfinder WHERE StudentID LIKE '$studentid'";
     $Location =  $_POST['Locationchange2'];

     $FirstNamefetch = sqlsrv_query($conn, $FirstNamebase); 
     $Surnamefetch = sqlsrv_query($conn, $Surnamebase); 
     $Userfetch = sqlsrv_query($conn, $Userbase); 
     

    $FirstName = sqlsrv_fetch_array($FirstNamefetch);
    $Surname = sqlsrv_fetch_array($Surnamefetch);
    $User = sqlsrv_fetch_array($Userfetch);

    $ExistingBase = "SELECT StudentID FROM StudentFinder WHERE StudentID LIKE $studentid";
    $ExistingA = sqlsrv_query($conn, $ExistingBase);
    $Existing = sqlsrv_fetch_array($ExistingA);

    if ($Existing['StudentID'] == $studentid)
    {
        $params = array ($studentid,$FirstName[FirstName],$Surname[Surname],$Location,$User[UserType]);
        $insert = ("INSERT INTO StudentFinder (StudentID,FirstName,Surname,LocationOfStudent,UserType,CurrentDate) VALUES (?,?,?,?,?,SYSDATETIME())");
     echo "Location Changed";
    }
    else
    {
        
        echo "No existing user with that ID";
    }
     $sql = sqlsrv_query($conn, $insert, $params);            

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
}
if ($_SERVER["REQUEST_METHOD"] == "GET")
{


$serverName = "sql.rde.hull.ac.uk";  
$connectionOptions = array("Database"=>"rde_555426");
$conn = sqlsrv_connect($serverName, $connectionOptions);

$studentid2 = $_GET['Studentid2'];
$LocationRetreiverbase = "SELECT TOP 1 LocationOfStudent FROM StudentFinder WHERE StudentID LIKE $studentid2 ORDER BY ID DESC";
$LocationRetreiverA = sqlsrv_query($conn, $LocationRetreiverbase); 
$LocationRetreiver = sqlsrv_fetch_array($LocationRetreiverA);

echo "The location of this student is: ";
echo $LocationRetreiver['LocationOfStudent'];


sqlsrv_close($conn);

}


?>