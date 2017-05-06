<?php    
/* 
*用户登录，服务器进行的处理 
*/  
    include("conn.php");  
    mysql_select_db("lbs");    
    $getid=$_POST['uid'];//客户端post过来的用户名  

    $sql=mysql_query("SELECT * FROM user WHERE username ='$getid'");   
    $result=mysql_fetch_assoc($sql);

    if(!empty($result)){  
        //存在该用户  
        mysql_query("UPDATE user SET status='1' WHERE id =$result[id]");
        /*这里的数组不需要加单引号*/ 
        $back['healthSum']=$result['current_health_sum']; 
        $back['states']="1";  
        $back['heartbeats']=$result['current_heartbeats']; 
        $back['temperature']=$result['current_temperature']; 
        $back['oxygenblood']=$result['current_oxygen_blood']; 
        $back['sports']=$result['current_sports']; 
        echo(json_encode($back));   
    }else{  
        //不存在该用户  
        $back['states']="-1";  
        $back['info']="user not exit";  
        echo(json_encode($back));   
    }      
    mysql_close();    
?>   
