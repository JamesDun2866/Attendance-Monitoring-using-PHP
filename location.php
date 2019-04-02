<?php 
 try  
 {  
     $serverName = "sql.rde.hull.ac.uk";  
     $connectionOptions = array("Database"=>"rde_555426");
     $conn = sqlsrv_connect($serverName, $connectionOptions);

    $StudentidErr = $LocationErr = "";
    $Studentid = $Location  = "";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;}


    if (empty($_POST["Studentid"])) {
        $StudentidErr = "StudentID is required";
      } else {
        $Studentid = test_input($_POST["Studentid"]);
        if (!preg_match("/^((?!(0))[0-9]{9})$/",$Studentid)) {
          $StudentidErr = "Only Numbers allowed"; 
        }      
        if ($Studentid == 0)
        {
          $StudentidErr = "Student ID Cannot be 0"; 
        } 
      }

      if (empty($_POST["Locationchange"])) {
        $LocationErr = "Location is required";
      } else {
        $Location = test_input($_POST["Locationchange"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$Location)) {
          $LocationErr = "Only letters and white space allowed"; 
        }
      }


     $Paramsforselect = array($studentid);
     $FirstNamebase = "SELECT FirstName From Studentfinder WHERE StudentID LIKE ?";
     $Surnamebase = "SELECT Surname From Studentfinder WHERE StudentID LIKE ?";
     $Userbase =  "SELECT UserType From Studentfinder WHERE StudentID LIKE ?";
     


    

     $FirstNamefetch = sqlsrv_query($conn, $FirstNamebase, $Paramsforselect); 
     $Surnamefetch = sqlsrv_query($conn, $Surnamebase, $Paramsforselect); 
     $Userfetch = sqlsrv_query($conn, $Userbase, $Paramsforselect); 
     

    $FirstName = sqlsrv_fetch_array($FirstNamefetch);
    $Surname = sqlsrv_fetch_array($Surnamefetch);
    $User = sqlsrv_fetch_array($Userfetch);

    $ExistingBase = "SELECT StudentID FROM StudentFinder WHERE StudentID LIKE ?";
    $ExistingA = sqlsrv_query($conn, $ExistingBase, $Paramsforselect);
    $Existing = sqlsrv_fetch_array($ExistingA);

    if ($Existing['StudentID'] == $studentid)
    {
        $params = array ($studentid,$FirstName[FirstName],$Surname[Surname],$Location,$User[UserType]);
        $insert = ("INSERT INTO StudentFinder (StudentID,FirstName,Surname,LocationOfStudent,UserType,CurrentDate) VALUES (?,?,?,?,?,SYSDATETIME())");
        $message = "Location Changed";
     echo "<script type='text/javascript'>alert('$message');</script>";
    }
    else
    {
        $message = "No existing user with that ID";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
     $sql = sqlsrv_query($conn, $insert, $params);            

     if (!$sql) {
         if (($errors = sqlsrv_errors()) != null) {
             foreach ($errors as $error) {
                 echo $error['message'];
             }
         }
     }
     header("Refresh:0; url=Changelocation.html"); 
     sqlsrv_close($conn);
 }  
 catch(Exception $e)  
 {  
     echo("Error!");  
 }  
?>