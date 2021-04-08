<?php
include('tradernavbar.php');
  ?>
  <div class="content">
<?php include('../base/profile.php'); ?>
  </div>
  <script>
var profile = document.getElementById("Profile");
profile.classList.add("active");
var product = document.getElementById("Products");
product.classList.remove("active");
  </script>