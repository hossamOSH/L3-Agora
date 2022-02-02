<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

	<body>

		<div align="center" class="container" >
			<div class="container p-3 my-3 bg-dark text-white">
			<h1 class="text-white bg-dark pl-3 rounded" style="font-size:50px;"align="center">Test Calculator</h1>
			</div>
			<div class="list-group">
			<a   href="<?php echo base_url();?>index.php/controller/add_form" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="margin-bottom: 20px;">Addition</a>
			<a   href="<?php echo base_url();?>index.php/controller/mult_form" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="margin-bottom: 20px;">Multiplication</a>
			<a   href="<?php echo base_url();?>index.php/controller/square_form" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" style="margin-bottom: 20px;">Racine Carré</a>	
	</div>
</div>
</body>
</html>