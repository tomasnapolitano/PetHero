<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <a href="<?php echo FRONT_ROOT . "Home/ShowHomeView" ?>"><h1>PetHero</h1></a>
      <h2><?php echo $_SESSION['loggedUser']->getUserName() ?></h2>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <li><a href="<?php echo FRONT_ROOT . "Home/Logout"?>">Log Out</a></li>
      </ul>
    </nav>
  </header>
</div>