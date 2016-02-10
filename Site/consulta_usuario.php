<?php

function getFieldName($field) {
	switch ($field) {
		case "cod_gravidade":
			$field_name = "Código Grav.";
			break;
		case "cod_infracao":
			$field_name = "Código Inf.";
			break;
		case "cod_condutor":
			$field_name = "Código Cond.";
			break;
		case "cod_telefone":
			$field_name = "Código Tel.";
			break;
		case "cod_auto":
			$field_name = "Código Multa";
			break;
		case "num_pontos":
			$field_name = "Pontos";
			break;
		case "desc_gravidade":
			$field_name = "Gravidade";
			break;
		case "desc_infracao":
			$field_name = "Gravidade";
			break;
		case "valor":
			$field_name = "Valor";
			break;
		case "primeiro_nome":
			$field_name = "Nome";
			break;
		case "ultimo_nome":
			$field_name = "Sobrenome";
			break;
		case "tipo_cnh":
			$field_name = "Tipo CNH";
			break;
		case "tipo_telefone":
			$field_name = "Tipo Tel.";
			break;
		case "num_telefone":
			$field_name = "Telefone";
			break;
		case "cod_local":
			$field_name = "DDD";
			break;
		case "data_infracao":
			$field_name = "Data Inf.";
			break;
		default:
			$field_name = "";
	}

	return $field_name;
}

$servername = "mysql.dcc.ufmg.br";
$username = "enzoroiz";
$password = "zozigo-7";
$dbname = "enzoroiz";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$commands = array("create", "alter", "drop", "insert","update", "delete", "set", "show", "help", "grant", "revoke", "start", "transaction", "savepoint", "commit", "rollback");

$sql = $_POST['query'];

$matches = array();
$match_found = preg_match_all(
              	"/\b(" . implode($commands,"|") . ")\b/i", 
                $sql, 
                $matches
              );

if($match_found){
	echo "denied";
} else {

	$result = $conn->query($sql);
	
	
	if($result){
		if ($result->num_rows > 0) {
		
			$fields = array();
			while ($field_info = mysqli_fetch_field($result)){
				array_push($fields, getFieldName($field_info->name));
			}

			echo "<div class='col-lg-12 nova_consulta mostrar_todos'>
					<button type='button' id='nova_consulta' class='btn btn-primary'>
						<span>Realizar Nova Consulta</span>
					</button>
				</div>
				<table class='table table-striped consulta'>  
				<thead>  
					<tr>"; 
						for($index = 0; $index < mysqli_num_fields($result); $index++){
							echo "<th>" . $fields[$index] . "</th>";
						}

				  	echo "</tr>
				</thead>
				<tbody>
					<tr>";
						for($index = 0; $index < mysqli_num_fields($result); $index++){
							echo "<td><input class='form-control consulta_search' type='text' placeholder='" 
								. $fields[$index] . "'></td>";								
						}
					echo "</tr>";

			// output data of each row
			$index = 0;
			while($row = $result->fetch_array(MYSQLI_NUM)) {
				echo "<tr>";
			
				for($index = 0; $index < mysqli_num_fields($result); $index++){
					echo "<td>".$row[$index]."</td>";
				}
			
				echo "</tr>";
			}

		} else {
		    echo "no_results";
		}
	} else {
		echo "Erro: " . $conn->error;
	}
}

$conn->close();

?>
