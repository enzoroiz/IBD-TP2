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
	$sql = "SELECT primeiro_nome, ultimo_nome, cod_infracao, desc_infracao FROM (tbl_condutor LIMIT 20000) natural join tbl_multa natural join tbl_infracao";
} else {
	$sql = "SELECT primeiro_nome, ultimo_nome, cod_infracao, desc_infracao FROM (tbl_condutor LIMIT 5) natural join tbl_multa natural join tbl_infracao";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table class='table table-striped multa_condutor'>  
		<thead>  
			<tr> 
		    		<th>Nome</th> 
				<th>Sobrenome</th> 
				<th>Código</th>
			    	<th>Infração</th>
		  	</tr>
		</thead>
		<tbody>
			<tr>
				<td><input class='form-control multa_condutor_search' type='text' placeholder='Nome'></td>
				<td><input class='form-control multa_condutor_search' type='text' placeholder='Sobrenome'></td>
				<td><input class='form-control multa_condutor_search' type='text' placeholder='Código'></td>
				<td><input class='form-control multa_condutor_search' type='text' placeholder='Infração'></td>
			</tr>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "<tr>  
		<td>" .$row['primeiro_nome']. "</td>
 		<td>" . $row['ultimo_nome'] . "</td>  
		<td>".$row['cod_infracao']."</td>
            	<td>".$row['desc_infracao']."</td>
  	</tr>";
    }
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_menos_multa_condutor' class='btn btn-primary'>
				<span>Mostrar menos</span>
			</button>
		</div>
		";
	} else {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_multa_condutor' class='btn btn-primary'>
				<span>Mostrar todos os resultados</span>
			</button>
		</div>";
	}
} else {
    echo "Consulta sem resultados.";
}

$conn->close();
?>
