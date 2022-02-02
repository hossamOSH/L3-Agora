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
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/style.css' />
        <script src="https://kit.fontawesome.com/86a1bcbcaf.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <a href="<?php echo base_url(); ?>index.php/controller/accueil" class="navbar-brand">Agora</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo base_url(); ?>index.php/controller/form_ajout/<?php echo $idg; ?>" class="nav-link">Ajouter Proposition</a>
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


    </style>


        <div class="container col-md-3 col-md-offset-4 well">
        <div class="form-group">
            <form action="<?php echo base_url(); ?>index.php/controller/ajout_proposition/" method="post">
                
                    
                    <label text-align="center" for="texte_prop">Proposition : </label>
                    <div class="container3">
                    <input type="hidden" name='id' value="<?php echo $idg;  ?>">
                    <input autocomplete="off" size="50" name="texte_prop" type="text" class="form_control" id=exa>
                    <input type="submit" name="submit" value="submit">
                    </form>
                    
                    
                    <form action="<?php echo base_url(); ?>index.php/controller/form_ajout/<?php echo $idg; ?>" method="post">
                    <input id="cancel-input" type="submit" name="cancel" value="cancel">
                    </form>
                    
                    
                    <div>
                    
                </div>


            
        </div>