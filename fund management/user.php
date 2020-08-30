<?php
session_start();
require 'config.php';
if(!$_SESSION['username']){
    echo "<script> window.location=\"loginuser.html\"</script>";
}
$uname = ($_SESSION['username']);

$pd = ($_SESSION['pass']);

$query = $con->prepare('select * from user where user.user_id = ? and user.password = ?');
$query->execute(array($uname,$pd));
$row = $query->fetch(PDO::FETCH_ASSOC);
$query1 = $con->prepare('select transactions.trans_id, type, amount, date, purpose from transactions inner join balance on transactions.trans_id = balance.trans_id where balance.user_id = ?');
$query1->execute(array($uname));

if(isset($_POST["logout"]))
{
  session_destroy();
  echo "<script>alert(\"Logged out successfully\")</script>";
  echo "<script> window.location=\"loginuser.html\"</script>";
}

?>
<html>
    <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="user.css">
    </head>
    <body>
    <div class="container-fluid c0">
        <div class="jumbotron f1">
          <img class="img-responsive img" src="./assets/logo1.png" alt="">
        </div>
      <div>
        <div class="container f0">
            <div class = "jumbotron bg-light cc1">
                <div class = "data1">
                    <?php
                        echo '<table width = "100%" border = "0" cellpadding = "6" cellspacing = "10">';                       
                        echo '<tr><th><h5>User Id </th><th>:    '.$row["user_id"].'</th></h5></th> </tr>';
                        echo '<tr><th><h5>Email Id </th><th>:    '.$row["email_id"].'</th></h5></th> </tr>';
                        echo '<tr><th><h5>Name </th><th>:    '.$row["name"].'</th></h5></th></tr>';
                        echo '<tr><th><h5>Contact </th><th>:    '.$row["contact"].'</th></h5></th></tr>';
                        echo '<tr><th><h5>Office </th><th> :    '.$row["office"].'</th></h5></th></tr>';
                        echo '<tr><th><h5>Registration Date </th><th>:    '.$row["add_date"].'</th></h5></th></tr>';
                        echo '<tr><th><h5>Available Balance</th><th>:    Rs.  '.$row["left_balance"].'/-</th></h5></th></tr>';
                        echo '</table>';
                        
                    ?>
                </div>
            </div>
            <div class ="row" style="text-align: center;">
                <form action ="view.php" method= "post" enctype="multipart/form-data">
                <!--input type="file" name="fileToUpload[]" id="fileToUpload" multiple-->
                <!--button class="btn btn-secondary mt-3" id="fileToUpload" name ="submit" type="submit">Upload Files</button-->
                <!--input type="submit" value="Upload File" name="submit"-->
                
                 <button class="btn btn-primary mt-3" name="view" type="submit">View Document</button>
                </form>
            </div>
            <div style="text-align:center;">
                <div class = "row">
			<div class = "col-sm-6 mb-1" style = "text-align : right"> 
				 <button  type="button" class="btn btn-primary" onclick="myfunction()">Past Transactions</button>	
			</div>
			<div class = "col-sm-6 mb-1" style = "text-align : left"> 
				 <button  type="button" class="btn btn-primary" onclick="location.href = 'edituser.php';">Edit Details</button>	
			</div>
		</div>
            </div>
        </div>
        <div id = "displaytable" class="container f3">
        <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Date</th>
                <th scope="col">Purpose</th>    
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    while($row1 = $query1->fetch(PDO::FETCH_ASSOC)){
                        echo '<tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$row1["trans_id"].'</td>
                        <td>'.$row1["type"].'</td>
                        <td>'.$row1["amount"].'</td>
                        <td>'.$row1["date"].'</td>
                        <td>'.$row1["purpose"].'</td>
                        </tr>';
                        $i = $i + 1;
                    } 
                ?>
            </tbody>
        </table>
        </div>
        <script>
            function myfunction() {
                var x = document.getElementById("displaytable");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
        <footer>
        <form action="user.php" method="post">
            <div class="copyright mb-1 mr-5" style="text-align: right;">
                <button class="btn btn-danger" name = "logout">Logout</button>
            </div>
        </form>
        </footer>
    </body>
</html>