<?php 
    include_once('header.php');
?>
<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1>PetHero</h1>
    </div>
    <!-- <nav id="mainav" class="fl_right">
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
        <li><a href="#">WELCOME</a></li>
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
    <h1 class="text-login">LOGIN TO MANAGE</h1>
</div>
  <div class="div-login">  
    <form action="<?php echo FRONT_ROOT."Home/Login" ?>" method="post">
        <input class="input-login" type="text" name="userName" placeholder="Nombre Usuario" required>
        <input class="input-login" type="password" name="password" placeholder="Contraseña" required >
        <button class="btn-login btn" type="submit" name="btnLogin">Ingresar</button>
      </form>
  </div>
</div>
