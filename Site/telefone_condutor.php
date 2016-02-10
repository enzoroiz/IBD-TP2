<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$sql = "SELECT primeiro_nome, ultimo_nome, cod_local, num_telefone FROM (tbl_condutor LIMIT 20000) natural join tbl_condutor_tem_telefones natural join tbl_telefones";
} else {
	$sql = "SELECT primeiro_nome, ultimo_nome, cod_local, num_telefone FROM (tbl_condutor LIMIT 9) natural join tbl_condutor_tem_telefones natural join tbl_telefones";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table class='table table-striped telefone_condutor'>  
		<thead>  
			<tr> 
		    		<th>Nome</th>  
			    	<th>Sobrenome</th>
				<th>DDD</th>
				<th>Telefone</th>
		  	</tr>
		</thead>
		<tbody>
			<tr>
				<td><input class='form-control telefone_condutor_search' type='text' placeholder='Nome'></td>
				<td><input class='form-control telefone_condutor_search' type='text' placeholder='Sobrenome'></td>
				<td><input class='form-control telefone_condutor_search' type='text' placeholder='DDD'></td>
				<td><input class='form-control telefone_condutor_search' type='text' placeholder='Telefone'></td>
			</tr>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "<tr>  
		<td>".$row['primeiro_nome']."</td>  
            	<td>".$row['ultimo_nome']."</td>
		<td>".$row['cod_local']."</td>
		<td>".$row['num_telefone']."</td>
  	</tr>";
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_menos_telefone_condutor' class='btn btn-primary'>
				<span>Mostrar menos</span>
			</button>
		</div>
		";
	} else {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_telefone_condutor' class='btn btn-primary'>
				<span>Mostrar todos os resultados</span>
			</button>
		</div>";
	}
} else {
    echo "Consulta sem resultados.";
}

$conn->close();
?>
