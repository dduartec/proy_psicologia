<?php
include_once("header.php");
?>
  <body>
  <section class="parent">
    <div class="child">
        <?php
            if(!func::checkLoginState($dbh)){
                header("location:login.php");
                exit();                
            }
            echo "Bienvenido ".$_SESSION['nombre'] ." !!!!";
        ?>
    </div>
</section>
  </body>
  <?php
  include_once("footer.php");
  ?>
