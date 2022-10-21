<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
     <!-- <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>-->
    </div>
  </div>
</div>




<!-- IMPLEMENTAR VISTA PARA VER MASCOTAS DE UN OWNER ESPECIFICO -->




<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Name</th>
              <!--<th style="width: 30%;">Species</th>-->
              <th style="width: 30%;">Breed</th>
              <th style="width: 30%;">Size</th>
              <th style="width: 30%;">Picture</th>
              <th style="width: 15%;">VacPlan</th>
              <th style="width: 10%;">VacObs</th>
            </tr>
          </thead>
          <tbody>
          
          
                  
          
          
          <?php foreach ($dogList as $dog) { 
                              $counter = 0;
                              if($dog->getOwnerId() == $_SESSION['loggedUser']->getId()){
                                $counter++;
                                ?>
                              <tr>
                                   <td><?php echo $dog->getName() ?></td>
                                   <!--<td><?php echo $dog->getPetSpecies() ?></td>-->
                                   <td><?php echo $dog->getBreed() ?></td>
                                   <td><?php echo $dog->getSize() ?></td>
                                   <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$dog->getPicture(); ?>" alt= "No hay imagen." style="width: 100px;"></td>
                                   <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$dog->getVacPlan(); ?>" alt= "No hay imagen." style="width: 100px;"></td>
                                   <td><?php echo $dog->getVacObs() ?></td>
                                   <td>
                                      <button type="submit" class="btn" value=""> Edit </button>
                                  </td>
                                  <td>
                                      <button type="submit" class="btn" value=""> Remove </button>
                                  </td>
                              </tr>
                         <?php }}
                         if($counter == 0)
                         { ?>
                           <tr>
                               <td colspan="7">You have not entered any Pets yet! Head over to "Add Pet" menu.</td>
                           </tr>   

                         <?php } ?>
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