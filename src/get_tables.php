<?php
$tables = array();
$response = array();
$servername = "acadmysql.duc.auburn.edu";
$username = "sza0096";
$password = "t1g3rs";
$dbname = "sza0096db";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = 'select `TABLE_NAME` from information_schema.tables WHERE table_schema = "sza0096db"';
$result = mysqli_query($conn,$sql);
if(!empty($result)){
	while ($row = mysqli_fetch_array($result)){
		array_push($tables, $row['TABLE_NAME']);
	}
}

foreach ($tables as $TABLE_NAME) {
	$temp_table = array();
	$sql = 'select * from `'.mysqli_real_escape_string($conn,$TABLE_NAME).'`';
	$result = mysqli_query($conn,$sql);
	if(!empty($result)&&@mysqli_num_rows($result)>0){
		while ($row = mysqli_fetch_assoc($result)){
			array_push($temp_table, $row);
		}
	}

	if(mysqli_num_rows($result)<1){
		$sql = 'SELECT tbl.* FROM (SELECT 1) AS ignore_me LEFT JOIN '.mysqli_real_escape_string($conn,$TABLE_NAME).' AS tbl ON 1 = 1 LIMIT 1';
		$result = mysqli_query($conn,$sql);
		if(!empty($result)){
			while ($row = mysqli_fetch_assoc($result)){
				array_push($temp_table, $row);
			}
		}
	}
	$response[$TABLE_NAME]=$temp_table;
}

echo str_replace('null', '""', json_encode($response));
?>