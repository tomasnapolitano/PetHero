<?php 
 include('header.php');
 include('nav-bar.php');
 $counter = 0;
?>
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
    </div>
  </div>
</div>
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="" method="">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 10%;">Owner Name</th>
              <th style="width: 10%;">Pet Name</th>
              <th style="width: 10%;">Start Date</th>
              <th style="width: 10%;">End Date</th>
              <th style="width: 12%;">Amount</th>
            </tr>
          </thead>
          <tbody>
   
          <?php foreach ($reservationList as $reservation) {
                              if($reservation->getKeeperId() == $_SESSION['loggedUser']->getId()){
                                $counter++;
                                ?>
                              <tr>
                                   <td><?php echo $reservation->getName() ?></td>
                                   <td><?php echo $reservation->getPetSpecies() ?></td>
                                   <td><?php echo $reservation->getBreed() ?></td>
                                   <td><?php echo $reservation->getSize() ?></td>
                                   <td>
                                      <button type="submit" class="btn" value=""> Edit </button>
                                  </td>
                                  <td>
                                      <button type="submit" class="btn" value=""> Remove </button>
                                  </td>
                              </tr>
                         <?php }}
                         if(!isset($counter) || $counter == 0)
                         { ?>
                           <tr>
                               <td colspan="8">You don't have reservations yet!</td>
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