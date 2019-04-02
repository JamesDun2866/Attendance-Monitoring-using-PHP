<?php 
 try  
 {  
     $serverName = "sql.rde.hull.ac.uk";  
     $connectionOptions = array("Database"=>"rde_555426");
     $conn = sqlsrv_connect($serverName, $connectionOptions);

    $StudentIDErr = $FirstNameErr = $SurnameErr = $LocationErr =$UserTypeErr = $StaffIDErr = "";
    $StudentID = $FirstName = $Surname = $Location = $UserType =$StaffID = "";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;}


        if (empty($_POST["StaffID"])) {
            $StaffIDErr = "StaffID is required";
          } else {
            $StaffID = test_input($_POST["StaffID"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^((?!(0))[0-9]{9})$/",$StaffID)) {
              $StaffIDErr = "Only letters and white space allowed"; 
            }
          }



    if (empty($_POST["StudentID"])) {
        $StudentIDErr = "StudentID is required";
      } else {
        $StudentID = test_input($_POST["StudentID"]);
        if (!preg_match("/^((?!(0))[0-9]{9})$/",$StudentID)) {
          $StudentIDErr = "Only Numbers allowed"; 
        }
        $overallmessage += $StudentIDErr;
      }



      if (empty($_POST["FirstName"])) {
        $FirstNameErr = "Firstname is required";
      } else {
        $FirstName = test_input($_POST["FirstName"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$FirstName)) {
          $FirstNameErr = "Only letters and white space allowed"; 
        }
      }

        
      if (empty($_POST["Surname"])) {
        $SurnameErr = "Surname is required";
      } else {
        $Surname = test_input($_POST["Surname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$Surname)) {
          $SurnameErr = "Only letters and white space allowed"; 
        }
      }



      if (empty($_POST["UserType"])) {
        $UserTypeErr = "UserType is required";
      } else {
        $UserType = test_input($_POST["UserType"]);
      }


      
     $isStaffbase = "SELECT StudentID FROM StudentFinder WHERE UserType LIKE 'Staff' AND  StudentID LIKE $StaffID";
     $isStaffa = sqlsrv_query($conn, $isStaffbase);
     $isStaff = sqlsrv_fetch_array($isStaffa);


    



    if(($StudentIDErr =="") && ($FirstNameErr =="") && ($SurnameErr =="") && $UserTypeErr == "")
    {
     

    if ($isStaff['StudentID'] == $StaffID)
    {
        $message = "User Updated";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $params = array ($FirstName,$Surname, $UserType);
        $insert = ("UPDATE StudentFinder SET Firstname = ?, Surname = ?, UserType = ? WHERE StudentID = '$StudentID'");
    }
    else
    {
        $message = "Edit Denied: You are not a staff user";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }
  else
  {
    $message = "Error Updating: Check your feilds";
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
     header("Refresh:0; url=UpdateDetails.html"); 
     sqlsrv_close($conn);
 }  
 catch(Exception $e)  
 {  
     echo("Error!");  
 }  

?>