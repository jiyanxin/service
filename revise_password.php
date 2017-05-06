<?php

//包含数据库连接文件
include("conn.php");  
    mysql_select_db("lbs");    
    $getid=$_POST['uid'];//客户端post过来的用户名  
    $getpwd=$_POST['originPassword'];//客户端post过来的密码 
    $newpwd=$_POST['newPassword']; 

    $sql=mysql_query("SELECT * FROM user WHERE username ='$getid'");   
    $result=mysql_fetch_assoc($sql);
    $query = "UPDATE user SET password='$newpwd' WHERE username='$getid'";

    if(!empty($result)){  
        //存在该用户  
        if($getpwd==$result['password']){  
            //用户名密码匹配正确  
	    $result = mysql_query($query);
	    if($result){
		$back['states']="1";
		$back['info']="successful!";
		echo(json_encode($back));
	
	    }else{
		$back['states']="-2";
		$back['info']="update failed!";
		echo(json_encode($back));
	    }	
            
        }else{
            $back['states']="-3";  
            $back['info']="password error";  
            echo(json_encode($back));   
        }  
  
    }else{  
        //不存在该用户  
        $back['states']="-1";  
        $back['info']="user not exit";  
        echo(json_encode($back));   
    }      
mysql_close();
?>