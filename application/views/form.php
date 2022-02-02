<?php 
echo validation_errors();
 ?>
<?php if ($nums == NULL){
	echo("Error");
}
var_dump($nums);
?>

<div class="container col-md-3 col-md-offset-4 well">
	<h2>Addition de deux Nombres</h2>
	<form action="" method="get">
		<div class="form-group">
			<label for="A">Entrez Nombre : </label>
			<select name="A" class="selectpicker">
				<?php
				foreach ($nums as $row) {
					?>

				 <option value="<?php echo $row['nb']; ?>" placeholder="<?php echo $row['nb'];?>"><?php echo $row['nb']; ?></option>
				<?php
			}
			?>
			</select>
		</div>

		<div class="form-group">
 <label for="X" >X</label>
<input name="X" type="text" class="form_control" id=exa value="<?php $X; ?>"placeholder="<?php echo $X;?>">
</div>


		<div class="form-group">
			<label for="result">Resultat : </label>
			<p class="text-success"><?php $res;?></p>
		</div>

		<input type="submit" name="submit" />
<!--
			<a href="<?php echo base_url();?>index.php/apicompute/add/<?php echo $row["nb"]?>/<?php echo $X;?>"><button type="button" class="btn btn-light">Submit</button>

			<input type="submit" name="submit" /></a>
-->
	
	</form>
</div>



















