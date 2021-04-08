<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/43e403f3dc.js" crossorigin="anonymous"></script>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Acme&display=swap');
.sidebar {
  margin: 0;
  padding: 0;
  width: 250px;
  background: white;
  position: fixed;
  overflow: auto;
  border-right: 1px solid black;
  height:100%;
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #1CAC78;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #18453B;
  color: white;
}

div.content {
  margin-left: 250px;
  padding: 1px 16px;
  height:auto;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}

@media screen and (max-width: 425px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
  .user-image{
    width: 40% !important;
}
.user-info{
    margin-top:30px !important;
    text-align: center;
    margin-right:60px;
}
}
.user-image{
    border:1px;
    border-radius:60px;
    width: 40%;
    height: auto;
}
.user-info{
    font-family: 'Acme', sans-serif !important;
    margin-top:20px;
    float:right;
}
@media screen and (max-width: 375px) {
  .user-image{
    width: 30% !important;
    height: auto;
}
}
</style>
</head>
<body>
<div class="sidebar">    
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
              <?php               
              include('../base/connect.php');
              $userid = $_SESSION['userid'];
              $sql = "Select * from USERS where USERID = $userid";
                            $result = oci_parse($conn, $sql);
                            oci_execute($result);                                                        
                            while($row=oci_fetch_assoc($result)){
                              $file_name = $row['IMAGE_NAME'];
                              if($file_name!=null)
                              {
                              echo"<img class='user-image' src='../images/users/$file_name' class='mx-auto img-fluid img-circle d-block' alt='no avatar'>";
                              }                                   
                              else{
                               echo"<img class='user-image' src='../images/users/user.png' class='mx-auto img-fluid img-circle d-block' alt='avatar'>";
                              }
                              echo'<div class="user-info">
                              '.$row['NAME'].'<br/>
                              Trader<br/>
                              Shop :'.$_SESSION['tradertype'].'
                              </div>'; 
                  }
                  oci_free_statement($result);
              ?> 

            </div>            
        </div>
    </div>
    <hr>        
<a id="Products" class="active" href="products.php">Products</a>
  <a id="Reports" href="http://127.0.0.1:8080/apex/r/team5/networkedappetite/login">Reports</a>
  <a href="#">Query</a>
  <hr>
  <a id="Profile" href="profile.php">Profile</a>
  <a id="product" href="../shop.php">Surf products.</a>
  <a id="Logout" href="../base/logout.php">Log Out</a>
</div>
</body>
</html>
