<?php

//�������ݿ������ļ�
include("conn.php");  
    mysql_select_db("lbs");    
    $getid=$_POST['uid'];//�ͻ���post�������û���  
    $getpwd=$_POST['originPassword'];//�ͻ���post���������� 
    $newpwd=$_POST['newPassword']; 

    $sql=mysql_query("SELECT * FROM user WHERE username ='$getid'");   
    $result=mysql_fetch_assoc($sql);
    $query = "UPDATE user SET password='$newpwd' WHERE username='$getid'";

    if(!empty($result)){  
        //���ڸ��û�  
        if($getpwd==$result['password']){  
            //�û�������ƥ����ȷ  
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
        //�����ڸ��û�  
        $back['states']="-1";  
        $back['info']="user not exit";  
        echo(json_encode($back));   
    }      
mysql_close();
?>