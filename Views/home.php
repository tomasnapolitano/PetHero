<?php 
    include_once('header.php');
    include_once('nav-bar.php');
?>
<div class="wrapper row1">
  <header id="header" class="clear"> 
    <!-- <div id="logo" class="fl_left">
      <h1>PetHero</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <li><a href="">ADD</a></li>
            <li><a href="">LIST/REMOVE</a></li>
      </ul>
    </nav> -->
  </header>
</div>
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li>Be the Hero this city wants AND needs!</li>
      </ul>
    </div>
  </div>
</div>


<!-- Esta pagina seria como la main page. HomeController deberia redirigir aca -->
<!-- Antes, deberia checkear si hay Session activa, sino redirigiría al login -->
<!-- Acá habría 4 botones: "Add Pet", "Check Keepers", "Check My Pets", "Be a Keeper" -->


<!-- #######################################################################3 -->
<div class="wrapper row3 img-login">
  <div class="div-login"><br>
    <h1 class="text-login">PetHero!</h1>
</div>
  <div class="div-login">  
    <a class="" href="<?php echo FRONT_ROOT . "Pet/ShowAddView"?>">Add Pet</a>
    <?php echo "|"?>  
    <a href="<?php echo FRONT_ROOT . "Owner/ShowKeeperListView"?>">Search Keepers</a>
    <?php echo "|"?>  
    <a href="<?php echo FRONT_ROOT . "Pet/ShowPetList"?>">View My Pets</a>
    <?php if ($_SESSION['loggedUser']->getUserRole()!=2) { ?>
      <?php echo "|"?>  
    <a href="<?php echo FRONT_ROOT . "Keeper/ShowRegisterView"?>">Be a Keeper!</a>
    <?php } ?>
  </div>
  <?php if ($message!=="" && $message!==1 && $message!==2){
                echo $message;
              }
              ?>
</div>
