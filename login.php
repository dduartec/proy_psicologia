<?php
include_once("header.php");
?>

<section class="parent">
    <div class="child">
        <?php
            if(!func::checkLoginState($dbh)){         
                if(isset($_POST['correo']) && isset($_POST['password'])){
                    $query ="SELECT * FROM psicologos WHERE correo= :correo AND password= :password";
                    
                    $correo = $_POST['correo'];
                    $password = $_POST['password'];

                    $stmt = $dbh->prepare($query);
                    $stmt ->execute(array(':correo' => $correo, ':password' => $password));
            
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($row['id']>0){                        
                        func::createRecord($dbh,$row['nombre'],$row['id']);
                        header("location:index.php");
                    }else{
                        echo '<div class="error"><h3 class="error">Correo o contraseña Incorrectos</h3></div>';
                    }
                }else{                    
                    echo '
                        <div  class="body-login">
                            <div class="container">
                                <div class="container container-login">
                                    <div class="row">
                                        <div class="col-sm-12 log-text">
                                            <h2>Ingresa</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8 offset-sm-2 myform-cont">
                                            <form role="form" action="login.php" method="post" class="">
                                                <div class="form-group">
                                                     <input type="text" name="correo" placeholder="Correo" class="form-control" id="correo"/>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="password" placeholder="Contraseña" class="form-control" id="password"/>
                                                </div>
                                                <button type="submit" class="mybtn">Ingresar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    ';
                }                
            }else{
                header("location:index.php");
            }
        ?>
    </div>
</section>
<?php
include_once("footer.php");
?>
