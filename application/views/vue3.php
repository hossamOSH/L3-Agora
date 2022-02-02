<!DOCTYPE html>
<html lang="en">

<body id="bg">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bootstrap 4 Introduction</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="main.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,700&display=swap" rel="stylesheet">
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/style.css' />
        <script src="https://kit.fontawesome.com/86a1bcbcaf.js" crossorigin="anonymous"></script>
    </head>


    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/controller/accueil/" class="nav-link">Agora</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/controller/props/<?php echo $idg->grou_id; ?>" class="nav-link">Propositions</a>
                </li>
                <li class="nav-item">
                    <?php

                    foreach ($prop as $row) {
                        $id = $row['pro_id'];


                    ?>

                        <a href="<?php echo base_url(); ?>index.php/controller/edit_prop/<?php echo $id; ?>" class="navbar-brand">Edition</a>
                </li>

            </ul>
        </div>

    </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <br>
    <br>
    <br>

    <style>
     
     input[type="submit"] {
    background-color: #62529c;
    border: none;
    color: #fff;
    padding: 5px 22px;
    text-decoration: none;
    margin: 5px 20px;
    cursor: pointer;
    margin-left: 5px 5px;
}

.fa-1x {
    font-size: 2em;
    margin-left: 20px;
    color: salmon;
}


    </style>
  
    <div class="form-group">
    <div class="container4">
        <form action="<?php echo base_url()?>index.php/controller/edit_proposition_name/" method="post"> 
                <div class="input-container">
                <label id="lb" for="texte_prop">Proposition</label>
                <input autocomplete="off" size=50 name="texte_prop" type="text" class="form_control" id=exa value="<?php echo $row['pro_nom']; ?>"> 
                <button  class="fas fa-edit fa-1x" type="submit" name="btnEnvoiForm" ></button>
                <input type="hidden" name='id' value="<?php echo $id;  ?>">               
                </div>
        </form>
        <form action="<?php echo base_url(); ?>index.php/controller/edit_prop/<?php echo $id;?>" method="post">
                    <input id="cancel-input2" type="submit" name="cancel" value="cancel">
        </form>
    </div>
    </div>
    


    <div class="form-group">
    <div class="container4">
        <form action="<?php echo base_url()?>index.php/controller/edit_proposition_avis/" method="post">
            <div class="input-container2">
                <label id="lb2" for="texte_avis">Avis</label>
                <input autocomplete="off" size=50 name="texte_avis" type="text" class="form_control" id=exa value="<?php echo $row['pro_avis']; ?>"> <button  class="fas fa-edit fa-1x" type="submit" name="btnEnvoiForm" ></button>
                <input type="hidden" name='id' value="<?php echo $id;  ?>">
                </div>
            </form>

         <form action="<?php echo base_url(); ?>index.php/controller/edit_prop/<?php echo $id;?>" method="post">
                    <input id="cancel-input3" type="submit" name="cancel" value="cancel">
          </form>
    </div>
    </div>




     <style>
         .addc{
             margin-bottom: 140px;
         }
         .test{
                margin-right:0px;
         }

         #ldr{
         	display: inline-block;
  			width: width: 710px;
  			text-align: right;
         }
         .fa-2x {
    font-size: 2em;
    margin-right: 680px;
    color: salmon;
}


        </style>



<?php
                        }
                        ?>



		<?php
		if (isset($_POST['submitted'])){
		    echo $_POST['texte_com'];
		}
		?>
		<html>
		<head>
		    <script type="text/javascript">
		  	var addInputOnce = (function() {
			    var executed = false;
			    return function() {
			        if (!executed) {
			            executed = true;
			            var div = document.getElementById('div_quotes');
		 				div.innerHTML += "\n<br />";
		   				div.innerHTML += "<input required='required' size=30 name='texte_com' style='margin-left: 615px; margin-bottom:50px;'/>";
		   				div.innerHTML += "<input type='submit' name='submitted'>";
						div.innerHTML += "\n<br />";
			        }
			    };
			})();
		    </script>
		</head>
	
		
		<form action="<?php echo base_url()?>index.php/controller/add_com/" method="post">
			<div class="container4">
		<div class="block" style="margin-left: -400px;">
			<label id="ldr" for="texte_com">Commentaires</label>
			&ensp;
            &ensp;
            &ensp;
			<input style="width:65px;height:55px;margin-bottom: -22px;" src="<?php echo $this->config->base_url(); ?>images/add.ico" type="image" value="Add" onClick="addInputOnce();">
			<input type="hidden" name='id' value="<?php echo $id;  ?>">
			</div>
			</div>
			<div id="div_quotes" style="margin-top: -30px;margin-left: 100px"></div>
		
		</form>
	
	

<style>

	#ulc #lic{
            display: inline-block;
    		/* You can also add some margins here to make it look prettier */
		    zoom:1;
		    *display:inline;
		    margin-bottom: 0px;
		    margin-left: 750px;

    /* this fix is needed for IE7- */      
                }

	#lic{
		  display: inline-block;
    /* You can also add some margins here to make it look prettier */
    zoom:1;
    *display:inline;
    /* this fix is needed for IE7- */

	}
	#ulc{
		   display: inline-block;
    /* You can also add some margins here to make it look prettier */
    zoom:1;
    *display:inline;
    /* this fix is needed for IE7- */
	}



	</style>

 <?php
                        foreach ($comms as $row) {        
                        ?>

<form action="<?php echo base_url()?>index.php/controller/add_rep/" method="post">
		<div class="list-group">
            <ol id="ulc" class="list-group" style="list-style-type: decimal">
			
                        <div class="container5">
                        <p>
                        <li id="lic" ><?php echo utf8_encode($row['com_texte']);?>   
                        &ensp;
                        &ensp;
                        &ensp;

                        <input type="radio" name='etat' <?php if ($row['com_etat'] == "1") { echo "checked='checked'"; }  ?> value="1">Fait 
                        <input type="radio" name='etat'  <?php if ($row['com_etat'] == "0") { echo "checked"; }  ?> value="0">Pas fait
                        &ensp;
                                      
                        <a title="delete" href="<?php echo base_url(); ?>index.php/controller/delete_com/<?php echo $row['pro_id'] ?>/<?php echo $row['com_id'] ?>"> <img src="<?php echo $this->config->base_url(); ?>images/delete.ico" style="width:40px;height:30px" alt=""></a>
                        <br/>
                        <br/>  
                       		<input type="hidden" name='idc' value="<?php echo $row['com_id'];  ?>">
                       		<input type="hidden" name='id' value="<?php echo $id;  ?>">

                       		<input autocomplete="off" size=30 name="texte_rep" type="text" class="form_control" id=exa2 value="<?php echo $row['com_reponse']?>">
                     		 <button  class="fas fa-edit fa-1x" style="margin-right: -60px;margin-top: -5px;" type="submit" name="submit2" ></button> 
                 		</li>
                        </p>
                </ol>
            

                          </form>
                          
        		
                       </div> 
                         <form action="<?php echo base_url(); ?>index.php/controller/edit_prop/<?php echo $id;?>" method="post">
                 			   <input id="cancel-input4" type="submit" name="cancel" value="cancel">
      					  </form>

                          </div>  

                    <br />
          
                </ul>

       </div>
 </form>




          
             <?php
                }
                    ?>  
		
	
	


		</html>   
       

 
</body>

</html>