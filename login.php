<?php    
/* 
*�û���¼�����������еĴ��� 
*/  
    include("conn.php");  
    mysql_select_db("lbs");    
    $getid=$_POST['uid'];//�ͻ���post�������û���  
    $getpwd=$_POST['pwd'];//�ͻ���post����������  
    $sql=mysql_query("SELECT * FROM user WHERE username ='$getid'");   
    $result=mysql_fetch_assoc($sql);

    if(!empty($result)){  
        //���ڸ��û�  
        if($getpwd==$result['password']){  
            //�û�������ƥ����ȷ  
            mysql_query("UPDATE user SET status='1' WHERE id =$result[id]");/*��������鲻��Ҫ�ӵ�����*/  
            $back['states']="1";  
            $back['info']="login success";  
            $back['sex']=$result['sex'];  
            $back['nicename']=$result['nicename'];  
            $back['pwd']=$result['password'];
            $back['phone']=$result['phone_number'];
            $back['mail']=$result['email'];
            $back['height']=$result['height'];
            $back['weigh']=$result['weigh'];
            echo(json_encode($back));   
        }else{/*�������*/  
            $back['states']="-2";  
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
