<?php

$tables = array();
$response = array();
$response['qerror'] = null;
$response['q_sucess'] = null;
$servername = "acadmysql.duc.auburn.edu";
$username = "sza0096";
$password = "t1g3rs";
$dbname = "sza0096db";

$conn = new mysqli($servername, $username, $password, $dbname);

if(stripos($_POST['query'], 'drop ') !== false){
	$response['qerror'] = "Drops aren't Allowed!";
	$response['table']= null;
	echo json_encode($response);
	exit();
}

$_POST['query'] = trim(preg_replace('/\s+/', ' ', $_POST['query']));

$sql = stripslashes($_POST['query']);
$result = mysqli_query($conn,$sql);
$temp_table= array();
if(!empty($result)&& @mysqli_num_rows($result)>0){
	while ($row = mysqli_fetch_assoc($result)){
		array_push($temp_table, $row);
	}
}
$response['table'] = $temp_table;

if(empty($response['table'])){
	$response['table'] = null;
}

$response['qerror']=mysqli_error($conn);

if(empty($response['qerror'])){
	$response['q_sucess']="sucess!";
}
echo json_encode($response);
?>