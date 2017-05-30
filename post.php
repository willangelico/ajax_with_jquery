<?php

// if($_REQUEST){	
// 	echo json_encode(["msg"=>"Request"]); exit;
// }
//echo "testes";



if($_GET){	
	$data = listAll();	
	echo json_encode($data); exit;
	//header("HTTP/1.0 404 NOT FOUND");
}

if($_POST){
	//var_dump( $_POST );	exit;

	$name = $_POST['name'];
	$email = $_POST['email'];
	$telephone = $_POST['telephone'];

	if($name == ""){
		echo json_encode(["status"=>false,"msg"=>"Fill in a name"]); exit;
	}
	if($email == ""){
		echo json_encode(["status"=>false,"msg"=>"Fill in a email"]); exit;
	}
	if($telephone == ""){
		echo json_encode(["status"=>false,"msg"=>"Fill in a telephone"]); exit;
	}
	$id = save($_POST);
	if($id){
		$data = find($id);
		echo json_encode(["status"=>true,"msg"=>"Success! id:{$id}","contacts"=>$data]); exit;
	}else{
		echo json_encode(["status"=>false,"msg"=>"ERRO DB"]); exit;
	}	
}

function conn(){
	$conn = new \PDO("mysql:host=localhost;dbname=ajax_jquery","root","");
	return $conn;
}

function save($data){
	$db = conn();
	//$query = "Insert into contact (name, email, tel) values (:name,:email,:telephone)";
	$query = "Insert into `contacts` (`name`, `email`, `telephone`) values (:name,:email,:telephone)";
	$stmt = $db->prepare($query);
	$stmt->bindValue(':name',$data['name']);
	$stmt->bindValue(':email',$data['email']);
	$stmt->bindValue(':telephone',$data['telephone']);
	$stmt->execute();
	return $db->lastInsertId();
	//
}

function listAll(){
	$db = conn();
	$query = "Select * from `contacts` order by id DESC";
	$stmt = $db->prepare($query);
	$stmt->execute();
	return $stmt->fetchAll();
}


function find($id){
	$db = conn();

	$query = "Select * from `contacts` where id=:id";
	$stmt = $db->prepare($query);
	$stmt->bindValue(':id',$id);
	$stmt->execute();
	return $stmt->fetch(\PDO::FETCH_ASSOC);
}