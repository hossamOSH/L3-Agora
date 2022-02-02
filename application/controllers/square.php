<?php 
echo validation_errors();
 ?>
<?php if ($nums == NULL){
	echo("Error");
}
?>

<div class="container col-md-3 col-md-offset-4 well">
	<h2>Racine carrée de deux Nombres</h2>
	<form action="<?php print $_SERVER['PHP_SELF'];?>" method="post">
		<div class="form-group">
			<label for="A">Entrez Nombre : </label>
			<select name="A" class="selectpicker">
				<?php
				foreach ($nums as $row){
					?>
				 <option value="<?php echo $row['nb']; ?>" placeholder="<?php echo $row['nb'];?>"><?php echo $row['nb']; ?></option>
				<?php
			}
			?>
			</select>
		</div>

		<div class="form-group">
 			<label for="X" >Entrez Nombre : </label>
				<input name="X" type="text" class="form_control" id=exa value="<?php $X; ?>">
		</div>


		<div class="form-group">
			<label for="result">Resultat : </label>
			<input type="text" id="result" name="result" size="10" value="<?php echo $res;?>">
		</div>
			<input type="submit" name="submit" />
	</form>
</div>
