<?php

//�������ݿ������ļ�
include('conn.php');

$username = $_POST['uid'];
$weigh = $_POST['weigh'];


//����û����Ƿ��Ѿ�����
$check_query = mysql_query("select * from user where username='$username' limit 1");
$query = "UPDATE user SET weigh='$weigh' WHERE username='$username'";

if(mysql_fetch_array($check_query)){
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
}
//д������
else{
	$back['states']="-1";
	$back['info']="user hasn't existed!";
	echo(json_encode($back));
    }
mysql_close();
?>