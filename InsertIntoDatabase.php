<?php 
 try  
 {  
     $serverName = "sql.rde.hull.ac.uk";  
     $connectionOptions = array("Database"=>"rde_555426");
     $conn = sqlsrv_connect($serverName, $connectionOptions);
    

    $StudentIDErr = $FirstNameErr = $SurnameErr = $LocationErr =$UserTypeErr = $StaffIDErr= "";
    $StudentID = $FirstName = $Surname = $Location = $UserType = $StaffID = "";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;}


    if (empty($_POST["StudentID"])) {
        $StudentIDErr = "StudentID is required";
      } else {
        $StudentID = test_input($_POST["StudentID"]);
        if (!preg_match("/^((?!(0))[0-9]{9})$/",$StudentID)) {
          $StudentIDErr = "Only Numbers allowed"; 
        }      
        if ($StudentID == 0)
        {
          $StudentIDErr = "Student ID Cannot be 0"; 
        } 
      }

      if (empty($_POST["StaffID"])) {
        $StaffIDErr = "StaffID is required";
      } else {
        $StaffID = test_input($_POST["StaffID"]);
        if (!preg_match("/^((?!(0))[0-9]{9})$/",$StaffID)) {
          $StaffIDErr = "Only Numbers allowed"; 
        }      
        if ($StaffID == 0)
        {
          $StaffIDErr = "StaffID Cannot be 0"; 
        } 
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
      if (empty($_POST["Location"])) {
        $LocationErr = "Location is required";
      } else {
        $Location = test_input($_POST["Location"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$Location)) {
          $LocationErr = "Only letters and white space allowed"; 
        }
      }
      if (empty($_POST["UserType"])) {
        $UserTypeErr = "UserType is required";
      } else {
        $UserType = test_input($_POST["UserType"]);
      }

    $ParamIsStaff = array ($StaffID);
    $isStaffbase = "SELECT StudentID FROM StudentFinder WHERE UserType LIKE 'Staff' AND  StudentID LIKE ?";
    $isStaffa = sqlsrv_query($conn, $isStaffbase, $ParamIsStaff);
    $isStaff = sqlsrv_fetch_array($isStaffa);

    $ExistingBase = "SELECT StudentID FROM StudentFinder";
    $ExistingA = sqlsrv_query($conn, $ExistingBase);
    $Existing = sqlsrv_fetch_array($ExistingA);
    

    if(($StudentIDErr =="") && ($FirstNameErr =="") && ($SurnameErr =="") && $LocationErr =="" && $UserTypeErr == "")
    {

      if ($Existing['StudentID'] ==$StudentID )
      {
        $message = "User Already Exists";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
      else{

    if ($UserType == 'Staff')
    {
    if ($isStaff['StudentID'] == $StaffID)
    {$paramsa = array ($StudentID,$FirstName,$Surname,$Location, $UserType);
      $insert = "INSERT INTO StudentFinder (StudentID,FirstName,Surname,LocationOfStudent,UserType,CurrentDate) VALUES (?,?,?,?,?,SYSDATETIME())";
      $message = "Staff Added";
     echo "<script type='text/javascript'>alert('$message');</script>";
     $sql = sqlsrv_query($conn, $insert, $paramsa); 
    }
    else
    {
     $message = "Invalid StaffID";
     echo "<script type='text/javascript'>alert('$message');</script>";
    }
  }

  if ($UserType =='Student')
  {
    $paramsb = array ($StudentID,$FirstName,$Surname,$Location, $UserType);
    $insert = ("INSERT INTO StudentFinder (StudentID,FirstName,Surname,LocationOfStudent,UserType,CurrentDate) VALUES (?,?,?,?,?,SYSDATETIME())");
    $message = "User Added";
     echo "<script type='text/javascript'>alert('$message');</script>";
     $sql = sqlsrv_query($conn, $insert, $paramsb); 
  }
}
  
      }
      else
      {
        $message = "Error Adding: Check your feilds";
     echo "<script type='text/javascript'>alert('$message');</script>";
      }

     if (!$sql) {
         if (($errors = sqlsrv_errors()) != null) {
             foreach ($errors as $error) {
                 echo $error['message'];
             }
         }
     }
    header("Refresh:0; url=Adduser.html"); 
     sqlsrv_close($conn);
 }  
 catch(Exception $e)  
 {  
     echo("Error!");  
 }  
?>
