<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> <!-- Sweet Alert -->  
    </head>
</html>

<?php
session_start();
require 'config.php';
$uname =  ($_SESSION['username']);  //username of user
$pd = ($_SESSION['pass']);

$query = $con->prepare('select email_id, name,password, contact, office from user where user.user_id = ?'); 
$query->execute(array($uname));
$row = $query->fetch(PDO::FETCH_ASSOC); //Fetches and displays User Details.

if(isset($_POST['but_submit']))
{
    $a = $_POST['mail_id'];  //Input for Email Id.
    $b = $_POST['username']; //Input for Username.
    $d = $_POST['office'];   //Input for Office Address.
    $e=$_POST['contact'];    //Input for Contact Number
    $g= $_POST['pass'];      //Input for Password

    $uppercase = preg_match('@[A-Z]@', $g); //returns 1 if password contains atleast one Upper case letter
    $lowercase = preg_match('@[a-z]@', $g); //returns 1 if password contains atleast one Lower case letter
    $number    = preg_match('@[0-9]@', $g); //returns 1 if password contains atleast one Number
    $specialChars = preg_match('@[^\w]@', $g); //returns 1 if password contains atleast one Special Character

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($g) < 8)
    // Password Validation
    // Password must be at least 8 characters in length
    // Password must have at least one upper case letter
    // Password must have at least one lower case letter
    // Password must have at least one number
    // Password must have at least one special character.
    {
        echo "<script type='text/javascript'>
        Swal.fire('Error','Password strength is Insufficient!!','error')
        </script>";
       //Error if conditions are not satisfied.
    }
    else
    {
      $sql1 = 'update user set 
               email_id =:a , 
              name = :b, 
              office = :d, 
              contact = :e, 
              password = :g
              where user_id=:h'; //sql query for updating details in table.
      $statement = $con->prepare($sql1);
      $new=$statement->execute(array(":a"=>$a,":b"=>$b,":g"=>$g,":e"=>$e,":d"=>$d,":h"=>$uname));
      $result = $statement->fetch(PDO::FETCH_ASSOC);

      if($new) 
      {
          echo "<script type='text/javascript'>
                    Swal.fire('Success','Edited User Details!!','success')
                </script>";
          $query = $con->prepare('select email_id, name,password, contact, office from user where user.user_id = ?');
          $query->execute(array($uname));
          $row = $query->fetch(PDO::FETCH_ASSOC); //Displays Details after Edit operation by fetching details from table in database. 
          echo "<script> window.location=\"user.php\"</script>";
        }
      else
      {
        echo "<script type='text/javascript'>
        Swal.fire('Error','Unable to Edit User Details!!','error')
        </script>"; 
      }
      
    }
}
?>
<html>
    <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="new_user.css">
    <body>
    <div class="grid-container">
  <div class="grid-item item1"><p><img src="./assets/logo.png" /></p></div>
  <div class="grid-item item2"><h1>FUND MANAGEMENT SYSTEM</h1></div>
  <div class="grid-item item3"><h1>CSE Department</h1><p>Admin Page</p></div>  
</div>
<div class="wrapper padding-top : 100px">
    <div class="sidebar">
        <h2 class="new_h1">Logged In As <p><?php echo $_SESSION["admin"]?></p></h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="new_user.php"><i class="fas fa-user-plus"></i>Create User</a></li>
			<li><a href="del_user.php"><i class="fas fa-address-book"></i>Delete User</a></li>
            <li><a href="access.php?request=user"><i class="far fa-file-alt"></i> Access User Records</a></li>
            <li>
            <form id = "my_form" action="adminUpload.php" method= "post">
            <a name  =  "view" href="javascript:{}" onclick="document.getElementById('my_form').submit();"><i class = "fas fa-file-alt"></i>View Document</a>
            <input type  ="hidden"  name = "view" value = "javascript:{}" />  
            </form>
            </li>
            <li><a href="transaction.php"><i class="fas fa-file-invoice-dollar"></i>Update Fund</a></li>
            <li><a href="access.php?request=transaction"><i class="fas fa-file-invoice-dollar"></i>Transactions log</a></li>
            <li>
            <form id = "my_form1" action="admin.php" method= "post">
            <a name  =  "logout" href="javascript:{}" onclick="document.getElementById('my_form1').submit();"><i class = "fas fa-sign-out-alt"></i>Log Out</a>
            <input type  ="hidden"  name = "logout" value = "javascript:{}" />
            </form>
            </li>
        </ul> 
      </div>
    </div>
</div>
  
      <div class="container">
        <div class="row">
          <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
              <div class="card-body">
                
                <h5 class="card-title text-center g3">Edit User Details</h5>
                <form action="" method = "post" class="form-signin">
                <div class="form-label-group">
                    <?php
                    echo '<input type="email" maxlength="29" name="mail_id" value="'.$row['email_id'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="inputEmail">Email Id</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input type= "text" maxlength="24" onkeypress="return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))" name="username" value="'.$row['name'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <label for="username">Name</label>
                  </div>
                  <div class="form-label-group">
                    <?php
                    echo '<input name="office" maxlength="20" value="'.$row['office'].'" class="form-control" placeholder="Office" Required>';
                    ?>
                    <label for="inputOffice">Office Address</label>
                  </div>
                  <div class="form-label-group">
                  <?php
                    echo '<input type="tel" name="contact" value="'.$row['contact'].'" class="form-control" placeholder="Name" pattern="[0-9]{10}" Required>';
                    ?>
                    <p style="text-align:center;font-size:0.8vw">Contact Number Format: 9876543210</p>
                    <label for="inputContact">Contact Number</label>
                  </div>
                  <div class="form-label-group">
                  <?php
                    echo '<input type="password"  maxlength="25" name="pass" value="'.$row['password'].'" class="form-control" placeholder="Name" Required>';
                    ?>
                    <p style="text-align:center;font-size:0.75vw">Password must be at least 8 characters in length, has at least one upper case letter,one lower case letter,one number,one special character </p>
                    <label for="inputPassword">Password</label>
                  </div>
                  <button class="btn btn-lg btn-primary btn-block text-uppercase"  id="lgin"  name ='but_submit' type="submit">Save Changes</button>
             </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
</html>