<!DOCTYPE html>
<html lang="fr">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bootstrap 4 Introduction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/style.css' />
</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">


        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/controller/accueil" class="nav-link">Agora</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/controller/accueil" class="nav-link">Départements</a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url(); ?>index.php/controller/conf/<?php echo $idc; ?>" class="navbar-brand">Groupes</a>
                </li>


            </ul>
        </div>

    </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>style/delete.ico' />



    <body id="bg">
        <?php
        foreach ($grps as $row) {
        ?>
            <div align="center" class="container">
                <div class="container p-3 my-3 bg-dark text-white">
                    <a style="text-decoration:none" href="<?php echo base_url(); ?>index.php/controller/props/<?php echo $row['grou_id'] ?>">
                        <h1 class="text-white bg-dark pl-3 rounded" style="font-size:50px;" align="center"><?php echo utf8_encode($row['grou_nom']); ?></h1>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
    </body>






</body>

</html>