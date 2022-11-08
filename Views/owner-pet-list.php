<?php 
 include('header.php');
 include('nav-bar.php');
 $counter = 0;
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
              <th style="width: 10%;">Name</th>
              <th style="width: 10%;">Species</th>
              <th style="width: 10%;">Breed</th>
              <th style="width: 10%;">Size</th>
              <th style="width: 12%;">Picture</th>
              <th style="width: 12%;">VacPlan</th>
              <th style="width: 12%;">VacObs</th>
              <th style="width: 12%;">Gif Video</th>
            </tr>
          </thead>
          <tbody>
          
          
                  
          
          
          <?php foreach ($petList as $pet) {
                              if($pet->getOwnerId() == $_SESSION['loggedUser']->getId()){
                                $counter++;
                                ?>
                              <tr>
                                   <td><?php echo $pet->getName() ?></td>
                                   <td><?php if($pet->getPetSpecies() == 1){echo "Dog";}else if ($pet->getPetSpecies() == 2){echo "Cat";} ?></td>
                                   <td><?php echo $pet->getBreed() ?></td>
                                   <td><?php echo $pet->getSize() ?></td>
                                   <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getPicture(); ?>" alt= "No hay imagen." style="width: 100px;"></td>
                                   <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getVacPlan(); ?>" alt= "No hay imagen." style="width: 100px;"></td>
                                   <td><?php echo $pet->getVacObs() ?></td>
                                   <td><img src="<?php echo FRONT_ROOT.IMG_PATH.$pet->getVideo(); ?>" alt= "No hay video." style="width: 200px;"></td>
                                   <!-- <td>
                                      <button type="submit" class="btn" value=""> Edit </button>
                                  </td>
                                  <td>
                                      <button type="submit" class="btn" value=""> Remove </button>
                                  </td> -->
                              </tr>
                         <?php }}
                         if(!isset($counter) || $counter == 0)
                         { ?>
                           <tr>
                               <td colspan="8">You have not entered any Pets yet! Head over to "Add Pet" menu.</td>
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