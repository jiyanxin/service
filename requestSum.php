<?php    
/* 
*�û���¼�����������еĴ��� 
*/  
    include("conn.php");  
    mysql_select_db("lbs");    
    $getid=$_POST['uid'];//�ͻ���post�������û���  

    $sql=mysql_query("SELECT * FROM user WHERE username ='$getid'");   
    $result=mysql_fetch_assoc($sql);

    if(!empty($result)){  
        //���ڸ��û�  
        mysql_query("UPDATE user SET status='1' WHERE id =$result[id]");
        /*��������鲻��Ҫ�ӵ�����*/ 
        $back['healthSum']=$result['current_health_sum']; 
        $back['states']="1";  
        $back['heartbeats']=$result['current_heartbeats']; 
        $back['temperature']=$result['current_temperature']; 
        $back['oxygenblood']=$result['current_oxygen_blood']; 
        $back['sports']=$result['current_sports']; 
        echo(json_encode($back));   
    }else{  
        //�����ڸ��û�  
        $back['states']="-1";  
        $back['info']="user not exit";  
        echo(json_encode($back));   
    }      
    mysql_close();    
?>   
