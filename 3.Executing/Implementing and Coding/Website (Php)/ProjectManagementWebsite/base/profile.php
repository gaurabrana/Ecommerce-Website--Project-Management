<?php
include('connect.php');      
if(isset($_POST['remove'])){
    $file_name = $_SESSION['file_data'];
    $user = $_SESSION['userid'];    
    $sql = "Update users set image_name = '' where USERID = $user";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    if($result){        
        unlink("../images/users/$file_name");
        header("Location: profile.php?message=Profile Picture Removed");       
    }
    oci_free_statement($result);
}
if(isset($_POST['edituser']))     
{
    extract($_POST);
    $name = $_POST['name'];
    $address = $_POST['address'];
    $age =$_POST['age'];
    $gender =$_POST['gender'];        
    $email = $_POST['email'];    
    if(empty($_POST['password']))
    {
        $sql = "UPDATE USERS set NAME='$name', ADDRESS='$address',AGE='$age',GENDER='$gender' where EMAIL='$email'";
        $result = oci_parse($conn,$sql);
        oci_execute($result);
        header("Location: profile.php");
    }
    else
    {
    $password=md5($_POST['password']);    
    $sql = "UPDATE USERS set NAME='$name', ADDRESS='$address',AGE='$age',GENDER='$gender', PASSWORD='$password' where EMAIL='$email'";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    header("Location: profile.php");
    }        
}
if(isset($_POST['image']))
{   
$target_dir = "../images/users/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$filename = $_FILES["fileToUpload"]["name"];
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    header("Location: profile.php?message=Sorry, file already exists.");
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an message
if ($uploadOk == 0) {
    header("Location: profile.php?message=Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} 
else {    
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $sql = "Update users set image_name='$filename'";
    $result = oci_parse($conn,$sql);
    oci_execute($result);
    oci_free_statement($result);
    header("Location: profile.php?message=Profile Picture Changed");      
  } else {
    header("Location: profile.php?message=An error occured. Try again.");  
  }
}
}

?>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Acme&display=swap');
    .details{
        font-family: 'Acme', sans-serif;
        font-size: 20px;        
    }    
    a{
        color:#01C423;
    }
    </style>
    </head>
    <body>
    <div class="container area">
    <div class="row my-2">
        <div class="col-lg-8 order-lg-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                </li>
                <?php
    if(isset($_SESSION['usertype'])){
    if($_SESSION['usertype']==2){
        echo'<li class="nav-item">
        <a href="" data-target="#messages" data-toggle="tab" class="nav-link">Messages</a>
    </li>';
    }
}
                ?>
               <li class="nav-item">
                    <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit</a>
                </li>
                <?php                
if(isset($_SESSION['usertype'])){
    if($_SESSION['usertype']==2){
        echo'<li class="nav-item">
        <a href="../shop.php"class="nav-link">Back to Shopping</a>
    </li>';
    }    
}
                ?>
    
            </ul>
            <div class="tab-content py-4">
                <div class="tab-pane active" id="profile">
                    <h5 class="mb-3">User Profile</h5>
                    <div class="row">
                        <div class="col-md-6">                            
                            <?php                                                                     
                            $userid = $_SESSION['userid'];
                            $sql = "Select * from USERS where USERID = $userid";
                            $result = oci_parse($conn, $sql);
                            oci_execute($result);                            
                            echo"<div class='details'>";
                            while($row=oci_fetch_assoc($result)){
                                if($row['TYPES']==2){
                                    echo"<h5>Customer</h5>";
                                }
                                else if($row['TYPES']==1){
                                    echo"<h5>Trader</h5>";
                                    echo"<h5>Shop Type: ".$_SESSION['tradertype']."</h5>";
                                    $_SESSION['type'] = $row['TYPES'];
                                }                      
                            $file_name = $row['IMAGE_NAME'];
                            $_SESSION['file_data'] = $file_name;                            
                            echo'Name: '.$row['NAME'];
                            echo'<br/>Address: '.$row['ADDRESS'];
                            echo'<br/>Age: '.$row['AGE'];
                            echo'<br/>Gender: '.$row['GENDER'];
                            echo'<br/>Email: <i>'.strtoupper($row['EMAIL'])."</i>";                            
                            strtoupper($row['EMAIL']);
                            echo"<br/>Joined Date: ".$row['JOINED_DATE'];
                            }
                            echo"</div>"; 
                            oci_free_statement($result);                           
                            ?>                           
                        </div>                        
                        
                    </div>
                    <!--/row-->
                </div>
                <div class="tab-pane" id="messages">
                    <div class="alert alert-info alert-dismissable">
                        <a class="panel-close close" data-dismiss="alert">×</a> This section contains your <strong>orders.</strong>
                    </div>
                    <table class="table table-hover table-striped">
                        <tbody>                            
                            <?php                                                
                            $sql = "Select * from payment where userid= $userid";
                        $res = oci_parse($conn, $sql);
                        oci_execute($res);
                        while($row=oci_fetch_assoc($res)){
                            echo'<tr>
                            <td>
                               <span class="float-right font-weight-bold">'.$row['PAIDDATE'].'</span> <a href="../ordersuccess.php?revisit=on&slot='.$row['ORDERID'].'">Order Completed At: </a>
                            </td>
                        </tr>';                                                      
                            }                            
?>                            
                        </tbody> 
                    </table>
                </div>
                <div class="tab-pane" id="edit">                    
                    <form method="POST" action="" onsubmit="return test();">
                    <?php 
                    $sql = "SELECT * from users where USERID = $userid";
                    $result = oci_parse($conn, $sql);
                    oci_execute($result);                    
                    while($row=oci_fetch_assoc($result))
                    {   
                        echo'<div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Name</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="name" type="text" value="'.$row['NAME'].'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Address</label>
                        <div class="col-lg-9">
                            <input class="form-control" name="address" type="text" value="'.$row['ADDRESS'].'" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Age</label>
                        <div class="col-lg-9">
                            <input id="age" class="form-control" name="age" type="text" value="'.$row['AGE'].'" required>
                            <p id="ageinfo"></p>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                        <div class="col-lg-9">
                            <input readonly class="form-control" name="gender" type="text" value="'.$row['GENDER'].'"required>
                            <p id="genderinfo"></p>
                            </div>
                    </div>                     
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Email</label>
                        <div class="col-lg-9">
                            <input  readonly class="form-control" name="email" type="email" value="'.$row['EMAIL'].'">                              
                        </div>
                    </div>';                                                                                       
                    }      
                    oci_free_statement($result);           
                    ?>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label">Password</label>
                        <div class="col-lg-9">
                            <input id="pass" class="form-control" name="password" oninput="myFunction1()" type="text" placeholder="If you want to change password">
                            <p id="password_message"></p>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label form-control-label"></label>
                        <div class="col-lg-9">
                            <input type="reset" class="btn btn-secondary" value="Cancel">
                            <input type="submit" id="change" name="edituser" class="btn btn-success" value="Save Changes">
                        </div>
                    </div>                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 order-lg-1 text-center">
            <?php  
            if($file_name!=null)
            {
                echo"<img style ='height:auto; width:200px;' src='../images/users/$file_name' class='mx-auto img-fluid img-circle d-block' alt='no avatar'>";
            }                                   
            else{
                echo"<img src='../images/users/user.png' class='mx-auto img-fluid img-circle d-block' alt='avatar'>";
            }
            
            ?>                        
            <label class="custom-file">
            <?php 
            if($file_name==null){
                echo'<form action="profile.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .png, .jpeg, .gif" required/>
                <input type="submit" class="btn btn-success" value="Upload Image" name="image">
              </form>';                   
            }
            else{                
                echo"<br/>
                <form action='profile.php' method='POST'>
                <input type='submit' class='btn btn-success' value='Remove profile picture' name='remove'>
                </form>";
            }               
            ?>
               
<?php
if(!empty($_GET['message'])){
    echo'<p>'.$_GET['message'].'</p>';   
    echo"<script>setTimeout(function() {window.location.href= 'profile.php';}, 3000);</script>"; 
}
?>

            </label>
        </div>
    </div>
</div>
<script>  
function test(){
        var element = document.getElementById("age").value;        
        var values = [];  
        values.push(element);
        var val = values.toString();  
        if(Number(element))
        {
            if(val>18){                
           return true;
            }       
            else
            {
            document.getElementById("ageinfo").innerHTML = " Should be Greater than 18.";
           return false;
            }     
        }  
        else{
            document.getElementById("ageinfo").innerHTML = "Invalid characters";
           return false;
        }        
}

  function myFunction1() {
  var elements = document.getElementById("pass").value;  
  var values = [];  
  values.push(elements);
  var val = values.toString();    
  if(val.length>0){
    if(val.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!$%@#£€*?&*_]{8,}$/)){
      document.getElementById("password_message").innerHTML = "Valid Password";
      document.getElementById("change").disabled = false;
    }  
    else{
      document.getElementById("password_message").innerHTML = "Invalid Password (at least 1 numeric, 1 lowercase and 1 uppercase needed.";
      document.getElementById("change").disabled = true;
    }   
  }
    return val;      
}
</script>
</body>
</html>