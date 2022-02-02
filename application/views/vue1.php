<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bootstrap 4 Introduction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css"> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@600&display=swap" rel="stylesheet"> 
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
                <a href="<?php echo base_url(); ?>index.php/controller/accueil" class="nav-link">Agora</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/controller/props/<?php echo $idg; ?>" class="navbar-brand">Propositions</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>index.php/controller/conf/<?php echo $confid->con_id; ?>" class="nav-link">Groupes</a>
            </li>
        </ul>
    </div>
</nav>



<body id="bg">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/delete.ico' />


    <div align="center" class="container">
        <div class="container p-3 my-3 bg-dark text-white">
            <h1 class="text-white bg-dark pl-3 rounded" style="font-size:50px;" align="center"> <?php echo $confname->con_nom; ?></h1>
            <?php
            foreach ($grps as $row) {
                $idg = $row['grou_id'];
            ?>
                <h2 class="text-white bg-dark pl-2 rounded" style="font-size:30px;" align="center"><?php echo $row['grou_nom']; ?></h1>
        </div>
        <p1 class="display-3">Ajoutez une proposition :
            <a title="add" href="<?php echo base_url(); ?>index.php/controller/form_ajout/<?php echo $idg; ?>"> <img src="<?php echo $this->config->base_url(); ?>images/add.ico" style="width:65px;height:55px"></a>
            </a>
        </p1>
            <?php
                                     }
                                     
            ?>
    <br />
    <br />

    <?php
    if (isset($props) && !empty($props)) {
    ?>
        <p1 margin-top="5px"> Liste des propositions</p1>
        <br />
        <br />

        

        <div class="list-group">
            <div class="list-group">
            <ul id="ul" class="list-group">
                <?php

                foreach ($props as $row) {
                    $idp = $row['pro_id'];
                    
                ?>

                <style>
                #ul #li{
                font-size:35px;       
                }
                </style>

                     <li id="li" class="list-group-item d-flex justify-content-between align-items-center"> <?php echo $row['pro_id']; ?> . <?php echo utf8_encode($row['pro_nom']); ?>
                        <p id="p2" text-align="right">
                        <a style="text-decoration:none" title="edit"   href="<?php echo base_url(); ?>index.php/controller/edit_prop/<?php echo $row['pro_id'] ?>"><span style="color: Tomato;"><i class="fas fa-edit fa-1x"></i></span> </a>
                        <a style="text-decoration:none" title="delete"   href="<?php echo base_url(); ?>index.php/controller/delete_prop/<?php echo $row['pro_id'] ?>/<?php echo $idg ?>"><span style="color: #D92D52;"><i class="fas fa-trash-alt fa-1x"></i></span> </a>
                         <a style="text-decoration:none" title="wiki"   href="<?php echo $row['pro_pmwikilink'] ?>"><i class="fab fa-wikipedia-w fa-1x"></i> </a>
                         </p>
                     </li>
            
                <?php
                                        }
                ?>
                 </ul>
                </div>
        </div>
    </div>

    <?php

        } else {
    ?>
    <p1 margin-top="5px"> Aucune Proposition</p1>
    <?php
               }
    ?>

</body>
</html>