<?php 
echo validation_errors();
 ?>



  

<form method="post" action="">

<div class="form-group">
 <label for="A" class="col-sm-2 ">A</label>
<input name="A" type="text" class="form_control" id=exa placeholder="<?php echo $_SESSION['a']; ?>">
</div>




<div class="form-group">
 <label for="X" >X</label>
<input name="X" type="text" class="form_control" id=exa placeholder="<?php echo $_SESSION['x']; ?>">
</div>

<div class="form-group">
 <label for="result" >Result</label>
<input name="result" type="text" class="form_control" id=exa placeholder="<?php
 echo $_SESSION['r']; ?>">
</div>


<button  href="<?php echo base_url();?>index.php/apicompute/square" type="submit" class="btn btn-primary">Submit</button>
</form>


<!-- href="<?php echo base_url();?>index.php/apicompute/add"-->