<?php
header('Access-Control-Allow-Origin: *');

$Mysqli = new mysqli('localhost', 'root' , '' , 'aula');

$request = $_server['REQUEST_METHOD'] == 'GET'  ? $_GET : $_POST;

switch ($request['acao']){
	
	case "Login":
	$usuario = addslashes($_POST['usuario']);
	$senha = addslashes($_POST)['senha'];
	
	$erro = "";
	$erro .= empty($usuario) ? "Informe o seu usuário \n" : "";
	$erro .= empty($senha) ? "Informe a sua senha \n" : "";
	
	$arr = array();
	
	if(empty($erro)){
		$query = "select * from alunos where usuario = '{$usuario}' and senha = '{$senha}'";
		$result = $Mysqli ->query ($query);
		
		if($result ->num_rows > 0){
			//usuario logado
			$obj = $result ->fetch_object();
			
			$arr['result'] = true;
		    $arr['login']['nome'] = $obj ->nome;
		}else{
			$arr['result'] = false;
		$arr['msg'] = "Usuário ou senha incorreto <br>". $query;			
		}		
	}else{
		$arr['result'] = false;
		$arr['msg'] = $erro;
	}
	
	echo json_encode($arr);
	break;	
	
}

?>