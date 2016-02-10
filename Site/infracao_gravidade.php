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
	$sql = "SELECT cod_infracao, desc_infracao, valor, num_pontos, desc_gravidade FROM tbl_infracao natural join tbl_gravidade_infracao";
} else {
	$sql = "SELECT cod_infracao, desc_infracao, valor, num_pontos, desc_gravidade FROM (tbl_infracao LIMIT 6) natural join tbl_gravidade_infracao";
}
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "<table class='table table-striped infracao_gravidade'>  
		<thead>  
			<tr> 
				<th>Código</th>
		    		<th>Infração</th>  
			    	<th>Valor</th>
				<th>Pontos</th>
				<th>Gravidade</th>
		  	</tr>
		</thead>
		<tbody>
			<tr>
				<td><input class='form-control infracao_gravidade_search' type='text' placeholder='Código'></td>
				<td><input class='form-control infracao_gravidade_search' type='text' placeholder='Infração'></td>
				<td><input class='form-control infracao_gravidade_search' type='text' placeholder='Valor'></td>
				<td><input class='form-control infracao_gravidade_search' type='text' placeholder='Pontos'></td>
				<td><input class='form-control infracao_gravidade_search' type='text' placeholder='Gravidade'></td>
			</tr>";

    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "<tr>  
		<td>".$row['cod_infracao']."</td>  
		<td>".$row['desc_infracao']."</td>  
            	<td>".$row['valor']."</td>
            	<td>".$row['num_pontos']."</td>	
            	<td>".$row['desc_gravidade']."</td>
  	</tr>";
    }

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_menos_infracao_gravidade' class='btn btn-primary'>
				<span>Mostrar menos</span>
			</button>
		</div>
		";
	} else {
		echo "</tbody>
		</table>
		<div class='mostrar_todos'>
			<button type='button' id='mostrar_infracao_gravidade' class='btn btn-primary'>
				<span>Mostrar todos os resultados</span>
			</button>
		</div>";
	}

} else {
    echo "Consulta sem resultados.";
}

$conn->close();
?>
