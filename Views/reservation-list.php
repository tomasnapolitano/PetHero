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
        <?php if ($_SESSION['loggedUser']->getUserRole() == 2) {?>
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 10%;">Owner Name</th>
              <th style="width: 10%;">Pet Name</th>
              <!-- <th style="width: 10%;">Start Date</th>
              <th style="width: 10%;">End Date</th> -->
              <th style="width: 12%;">Amount</th>
            </tr>
          </thead>
          <tbody>
   
          <?php foreach ($reservationList as $reservation) {
                              if($reservation->getKeeper()->GetId() == $_SESSION['loggedUser']->getId()){
                                $counter++;
                                ?>
                              <tr>
                                   <td><?php echo $reservation->getOwner()->getName() . " " . $reservation->getOwner()->getLastName() ?></td>
                                   <td><?php echo $reservation->getPet()->getName() ?></td>
                                   <td><?php echo $reservation->getAmount() ?></td>
                                  <form action="Reservation/ShowReservationListView" method="">
                                  <td style="width: 10%;">
                                      <button type="submit" class="btn" value=""> Confirm </button>
                                  </td>
                                  </form>
                              </tr>
                         <?php }
                               
                            } ?>
                            <?php
                         if(!isset($counter) || $counter == 0)
                         { ?>
                           <tr>
                               <td colspan="8">Owners haven't placed any reservations for you yet!</td>
                           </tr>   

                         <?php } ?>
        </tbody>
        </table> <?php } ?>
          <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 10%;">Keeper Name</th>
              <th style="width: 10%;">Pet Name</th>
              <!-- <th style="width: 10%;">Start Date</th>
              <th style="width: 10%;">End Date</th> -->
              <th style="width: 12%;">Amount</th>
            </tr>
          </thead>
          <tbody>
   
          <?php 
          $counterOwn= 0;
          foreach ($reservationList as $reservation) {
                  
                              if($reservation->getOwner()->getId() == $_SESSION['loggedUser']->getId()) {
                                
                                $counterOwn++;
                                
                                ?>
                                <tr>
                                   <td><?php echo $reservation->getKeeper()->getName() . " " . $reservation->getKeeper()->getLastName() ?></td>
                                   <td><?php echo $reservation->getPet()->getName() ?></td>
                                   <td><?php echo $reservation->getAmount() ?></td>
                                  <form action="Reservation/ShowReservationListView" method="">
                                  <td style="width: 10%;">
                                      <button type="submit" class="btn" value=""> Cancel </button>
                                  </td>
                                  </form>
                              </tr> 
                              
                              
                              <?php
                              } 
                            } ?>
                            <?php
                         if(!isset($counterOwn) || $counterOwn == 0)
                         { ?>
                           <tr>
                             <td colspan="8">You haven't placed any reservations yet!</td>
                            </tr>   
                            
                            <?php } ?>
                          </tbody>
                          </table>
                        
                        </form> 
                          </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>