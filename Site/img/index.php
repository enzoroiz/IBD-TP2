<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Sistema de Multas</title>
		<!-- CSS -->
	    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	    <link href="css/bootstrap.min.css" rel="stylesheet">
	    <link href="css/sweetalert.css" rel="stylesheet">
	    <link href="css/style.css" rel="stylesheet">

	    <!-- Scripts -->
	    <script src="js/jquery-2.1.3.min.js"></script>
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/sweet-alert.js"></script>
	    <script src="js/multas.js"></script>
	    <link rel="icon" type="img/ico" href="img/favicon.ico">
	</head>
	<body>
		<div id="wrapper">
			<div class="banner">
				<div class="container col-lg-offset-4 col-lg-4">
					<div class="jumbotron">
					<h1>Sistema de Multas</h1>      
					<p>Trabalho de Introdução a Banco de Dados.</p>
					</div>     
				</div>
			</div>

			<div id="content" class="col-lg-offset-1 col-lg-10">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#condutor" aria-controls="condutor" role="tab" data-toggle="tab">Condutor</a></li>
					<li role="presentation"><a href="#infracao_gravidade" aria-controls="infracao_gravidade" role="tab" data-toggle="tab">Infração e Gravidade</a></li>
					<li role="presentation"><a href="#multa_condutor" aria-controls="multa_condutor" role="tab" data-toggle="tab">Multas de Condutor</a></li>
					<li role="presentation"><a href="#telefone_condutor" aria-controls="telefone_condutor" role="tab" data-toggle="tab">Telefones de Condutor</a></li>
					<li role="presentation"><a href="#consulta" aria-controls="consulta" role="tab" data-toggle="tab">Faça Sua Consulta</a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="condutor"><?php include 'condutor.php'?></div>
					<div role="tabpanel" class="tab-pane" id="infracao_gravidade"><?php include 'infracao_gravidade.php'?></div>
					<div role="tabpanel" class="tab-pane" id="multa_condutor"><?php include 'multa_condutor.php'?></div>
					<div role="tabpanel" class="tab-pane" id="telefone_condutor"><?php include 'telefone_condutor.php'?></div>
					<div role="tabpanel" class="tab-pane" id="consulta">
						<div class="form-group col-sm-9 col-md-8 col-lg-8">
							<br/>
							<label for="consulta">Digite sua consulta:</label>
							<textarea class="form-control" rows="6" id="consulta_text" placeholder="SELECT . . ."></textarea>
							<br/>
							<button type='button' id='consultar' class='btn btn-primary'>
								<span>Consultar</span>
							</button>
						</div>
						<div class="col-sm-3 col-md-4 col-lg-4">
							<br/>
							<label for="diagrama_er">Diagrama ER:</label>
							<a href="#" id="diagrama_er" class="thumbnail">
								<img src="img/multas_database.png" alt="Diagrama ER">
							</a>
							<div id="image_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
								<div id="image_container" class="modal-content">
									<div class="modal-body">
										<div>
											<a id="modal_image_close" href="#" class="icon_close">
											<span class="glyphicon glyphicon-remove"></span>
											</a>
										</div>
										<img src="img/multas_database.png" class="img-responsive">
									</div>
								</div>
							</div>
						</div>				
					</div>
				</div>			
			</div>
			<div id="push"></div>
		</div>
		<div id="footer" class="col-sm-12 col-md-12 col-lg-12">
			<div class="col-sm-3 col-md-3 col-lg-3">
				<img src="img/dcc.gif" alt="Logo DCC">
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<h2>IBD</h2>
				<p>Prof. Mirella Moro</p>
				<p>2015/2</span>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<h2>Alunos</h2>
				<p>Enzo Roiz</p>
				<p>Bernardo Brescia</p>
				<p>Renato Oliveira</p>
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3">
				<h2>Aviso</h2>
				<p>Dados fictícios com o propósito de uso apenas para disciplina. Consultas com limite de 20 mil resultados.</p>
			</div>
			<div class="col-sm-2 col-md-2 col-lg-2">
				<img src="img/ufmg.png" class="right" alt="Logo DCC">
			</div>
		</div>
	</body>
</html>
