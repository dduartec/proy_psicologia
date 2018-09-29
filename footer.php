</footer>

<?php
include_once('header.php');
echo '
    <a href ="index.php">Index</a> |';
    if(func::checkLoginState($dbh)){
        echo '<a href="logout.php">Logout</a>';
    }else{
        echo '<a href="login.php">Login</a>';
    }
?>

</footer>
</html>