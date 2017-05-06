<?php

header("Content-type: text/html; charset=UTF-8");
//确保在连接客户端时不会超时
ignore_user_abort();
set_time_limit(0);

//$ip = '127.0.0.1';
$ip = '120.25.207.101';
$port = 1935;

/*
 +-------------------------------
 *    @socket通信整个过程
 +-------------------------------
 *    @socket_create
 *    @socket_bind
 *    @socket_listen
 *    @socket_accept
 *    @socket_read
 *    @socket_write
 *    @socket_close
 +--------------------------------
 */

/*----------------    以下操作都是手册上的    -------------------*/
if(($sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0) {
    echo "socket_create() failed reason:".socket_strerror($sock)."\n";
}

if(($ret = socket_bind($sock,$ip,$port)) < 0) {
    echo "socket_bind() failed reason:".socket_strerror($ret)."\n";
}

if(($ret = socket_listen($sock,4)) < 0) {
    echo "socket_listen() failed reason:".socket_strerror($ret)."\n";
}

$count = 0;

while(true) {

    if (($msgsock = socket_accept($sock)) < 0) {
        echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . "\n";
        break;
    } else {
        
        //发到客户端
        $msg ="Successful!\n";
        socket_write($msgsock, $msg, strlen($msg));
        
        echo "Successful!!\n";
        $buf = socket_read($msgsock,8192);
        
        
        $talkback = "Recieve msg:$buf\n";
        echo $talkback;


        $de_json = json_decode($buf,TRUE);
        //$count = count($de_json);
        
        /**心率**/
        include("conn.php");

        if($de_json['heartbeats']){
            $username = $de_json['username'];
            $heartbeats = $de_json['heartbeats'];
     
            echo $username;
            echo " ";
            echo $heartbeats;
            echo " ";

            $sql=mysql_query("SELECT * FROM user WHERE username ='$username'");   
            $result=mysql_fetch_assoc($sql); 
            if(!empty($result)){  
            //存在该用户  
          
                $sql_update = "UPDATE user SET current_heartbeats='$heartbeats' WHERE username='$username'";
                mysql_query($sql_update,$conn);

                $sql_date = "UPDATE user SET date_heartbeats=now() WHERE username='$username'";
                mysql_query($sql_date,$conn);
        
                $sql = "INSERT INTO log_heartbeats(username,heartbeats,date_heartbeats)VALUES('$username','$heartbeats',now())";
                if(mysql_query($sql,$conn)){
                    $back['states']="1";
                    $back['info']="successful!";
                    echo(json_encode($back));
                    
                } else {
                    $back['states']="-2";
                    $back['info']="error!";
                    echo(json_encode($back));
                }
            }else{  
                //不存在该用户  
                $back['states']="-1";  
                $back['info']="user not exit";  
                echo(json_encode($back));   
            }      
        }

        /**体温**/

        if($de_json['temperature']){
            $username = $de_json['username'];
            $temperature = $de_json['temperature'];
 
            echo $username;
            echo " ";
            echo $temperature;
            echo " ";

            $sql=mysql_query("SELECT * FROM user WHERE username ='$username'");   
            $result=mysql_fetch_assoc($sql); 
            if(!empty($result)){  
            //存在该用户  
            
                $sql_update = "UPDATE user SET current_temperature='$temperature' WHERE username='$username'";
                mysql_query($sql_update,$conn);

                $sql_date = "UPDATE user SET date_temperature=now() WHERE username='$username'";
                mysql_query($sql_date,$conn);

                $sql = "INSERT INTO log_temperature(username,temperature,date_temperature)VALUES('$username','$temperature',now())";
                if(mysql_query($sql,$conn)){
                    $back['states']="1";
                    $back['info']="successful!";
                    echo(json_encode($back));
                    
                } else {
                    $back['states']="-2";
                    $back['info']="error!";
                    echo(json_encode($back));
                }
            }else{  
                //不存在该用户  
                $back['states']="-1";  
                $back['info']="user not exit";  
                echo(json_encode($back));   
            }      
        }

        /**血氧饱和度*/

        if($de_json['oxygenblood']){
            $username = $de_json['username'];
            $oxygenblood = $de_json['oxygenblood'];
            echo $username;
            echo " ";
            echo $oxygenblood;
            echo " ";

            $sql=mysql_query("SELECT * FROM user WHERE username ='$username'");   
            $result=mysql_fetch_assoc($sql); 
            if(!empty($result)){  
            //存在该用户  
                
                $sql_update = "UPDATE user SET current_oxygen_blood='$oxygenblood' WHERE username='$username'";
                mysql_query($sql_update,$conn);

                $sql_date = "UPDATE user SET date_oxygen_blood=now() WHERE username='$username'";
                mysql_query($sql_date,$conn);

                $sql = "INSERT INTO log_oxygen_blood(username,oxygen_blood,date_oxygen_blood)VALUES('$username','$oxygenblood',now())";
                if(mysql_query($sql,$conn)){
                    $back['states']="1";
                    $back['info']="successful!";
                    echo(json_encode($back));
                    
                } else {
                    $back['states']="-2";
                    $back['info']="error!";
                    echo(json_encode($back));
                }
            }else{  
                //不存在该用户  
                $back['states']="-1";  
                $back['info']="user not exit";  
                echo(json_encode($back));   
            }      
        } 

        mysql_close();  
       
    }
    socket_close($msgsock);

} 

socket_close($sock);
?>