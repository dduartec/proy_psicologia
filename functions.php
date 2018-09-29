<?php

class func{
    public static function checkLoginState($dbh){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_COOKIE['psicologo_id']) && isset($_COOKIE['token']) && isset($_COOKIE['serial'])){
            $query ="SELECT * FROM sessions WHERE psicologo_id = :psicologo_id AND token = :token AND serial = :serial;";
            
            $psicologo_id=$_COOKIE['psicologo_id'];
            $token =$_COOKIE['token'];
            $serial =$_COOKIE['serial'];
            
            $stmt = $dbh->prepare($query);
            $stmt ->execute(array(':psicologo_id' => $psicologo_id, ':token' => $token, ':serial' => $serial));
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row['psicologo_id']>0){
                if(
                    $row['psicologo_id'] == $_COOKIE['psicologo_id'] &&
                    $row['token'] == $_COOKIE['token'] &&
                    $row['serial'] == $_COOKIE['serial'] 
                ){
                    if(
                        $row['psicologo_id'] == $_SESSION['psicologo_id'] &&
                        $row['token'] == $_SESSION['token'] &&
                        $row['serial'] == $_SESSION['serial'] 
                    ){
                        return true;
                    }else{
                        //func::createSession($_COOKIE['nombre'] ,$_COOKIE['psicologo_id'] ,$_COOKIE['token'] ,$_COOKIE['serial'] );
                        //return true;
                    }
                }
            }
        }
    }

    public static function createRecord($dbh,$nombre,$psicologo_id){
        $dbh->prepare('DELETE FROM sessions WHERE psicologo_id= :psicologo_id;')->execute(array(':psicologo_id'=>$psicologo_id));

        $token=func::createString(32);
        $serial=func::createString(32);

        func::createCookie($nombre,$psicologo_id,$token,$serial);
        func::createSession($nombre,$psicologo_id,$token,$serial);

        $stmt = $dbh->prepare('INSERT INTO sessions (psicologo_id, token, serial, date) VALUES (:psicologo_id,:token,:serial,"'.date("Y/m/d") .'")');
        $stmt ->execute(array(':psicologo_id' => $psicologo_id, ':token' => $token, ':serial' => $serial));

        

    }

    public static function createCookie($nombre,$psicologo_id,$token,$serial){
        echo " create cookie ";
        setcookie('nombre',$nombre,time() + (86400)*30,"/");
        setcookie('psicologo_id',$psicologo_id,time() + (86400)*30,"/");
        setcookie('token',$token,time() + (86400)*30,"/");
        setcookie('serial',$serial,time() + (86400)*30,"/");
    }
    public static function deleteCookie(){        
        setcookie('nombre','',time() -1,"/");
        setcookie('psicologo_id','',time() -10,"/");
        setcookie('token','',time() -1,"/");
        setcookie('serial','',time() -1,"/");
    }
    public static function createSession($nombre,$psicologo_id,$token,$serial){
        echo " create session ";
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['nombre']=$nombre;
        $_SESSION['psicologo_id']=$psicologo_id;
        $_SESSION['token']=$token;
        $_SESSION['serial']=$serial;
    }

    public static function createString($len){
        $string="1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0pASDFGHJKLZXCVBNMQWERTYUIOP";
        $s ='';
        $r_new='';
        $r_old='';
        for($i = 1;$i<$len;$i++){
            while($r_old==$r_new){
                $r_new= rand(0,60);
            }
            $r_old=$r_new;
            $s=$s.$string[$r_new];
        }
        return substr(str_shuffle($string),0,$len);
    }

    
}
?>