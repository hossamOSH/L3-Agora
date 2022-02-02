<?php 
echo validation_errors();
 ?>
<?php
if($this->input->get('submit')){
	$v1=$this->input->get('A');
	$v2=$this->input->get('X');
	header("Location: http://test/index.php/controller/add/".$v1."/".$v2."");
}
else if($this->input->get('back')){
	header("Location: http://test/index.php/controller/index");
}

?>
 

<div class="container col-md-3 col-md-offset-4 well">
	<h2>Addition</h2>
	<form action="" method="get" >
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
 			<label for="X" >Entrez Nombre : </label>
				<input name="X" type="text" class="form_control" id=exa placeholder="<?php echo $v2 ?>" value="<?php echo $this->input->get('X');?>">
		</div>
			
		<div class="form-group">
			<label for="result">Resultat : </label>
			<input type="text" id="result" name="result" value="<?php echo $result; ?>">
		</div>
		
		<input type="submit" name="submit" value="submit">
		<input  type="submit" name="back" value="back">
	</form>
</div> 
