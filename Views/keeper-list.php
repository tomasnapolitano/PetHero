<?php 
 include('header.php');
 include('nav-bar.php');

use Models\Keeper;
use Models\Owner;

?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>
    </div>
  </div>
</div>




<!-- IMPLEMENTAR VISTA PARA VER KEEPERS DESDE UN OWNER -->




<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT . "Owner/ShowKeeperListView" ?>" method="get">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Name</th>
              <th style="width: 30%;">Last Name</th>
              <th style="width: 30%;">Pet Size</th>
              <th style="width: 15%;">Price</th>
              <th style="width: 10%;">Availability</th>
            </tr>
          </thead>
          <tbody>
          <?php
            foreach ($keepersList as $keeper) {
              if($keeper->getUserRole() == 2){  
          ?>    <tr>
                  <td><?php echo $keeper->getname() ?></td>
                  <td><?php echo $keeper->getLastName() ?></td>
                  <td><?php echo $keeper->getPetSize() ?></td>
                  <td><?php echo $keeper->getPrice() ?></td>
                  <td><?php echo $keeper->getAvailability() ?></td>
                <td>
                  <button type="submit" class="btn" value=""> Remove </button>
                </td>
              </tr><?php
              }
            }?> 
          </tbody>
        </table></form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>