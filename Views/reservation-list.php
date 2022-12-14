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
        
          <?php if ($_SESSION['loggedUser']->getUserRole() == 2) { ?>
            <table style="text-align:center;">
              <thead>
                <tr>
                  <th style="width: 10%;">Owner Name</th>
                  <th style="width: 10%;">Pet Name</th>
                   <th style="width: 10%;">Dates</th>
              <!--<th style="width: 10%;">End Date</th> -->
                  <th style="width: 12%;">Amount($)</th>
                  <th style="width: 12%;">Observation</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($reservationList as $reservation) {
                  if ($reservation->getKeeper()->GetId() == $_SESSION['loggedUser']->getId()) {
                    $counter++;
                ?>
                    <tr>

                      <td><?php echo $reservation->getOwner()->getName() . " " . $reservation->getOwner()->getLastName() ?></td>
                      <td><?php echo $reservation->getPet()->getName() ?></td>
                      <td><?php foreach ($reservation->getDateList() as $date)
                    {echo $date->GetDate() . " ";}?></td>
                      <td><?php echo $reservation->getAmount() ?></td>

                      <td style="width: 10%;">
                        <?php if ($reservation->getIsAccepted() == true) {
                          echo "Reservation Accepted";
                        } elseif ($reservation->getIsAccepted() === null) {
                          echo "Pending Confirmation";
                        } else {
                          echo "Reservation Rejected";
                        }
                        ?>
                      </td>

                      <?php if ($reservation->getIsAccepted() === null) { ?>
                        <td style="width: 0%;">
                          <form action="<?php echo FRONT_ROOT . "Reservation/ConfirmReservation" ?>" method="post">
                            <button type="submit" class="btn" name="reservationId" value=<?php echo $reservation->getId() ?>> Confirm </button>
                          </form>
                        </td>

                        <td style="width: 0%;">
                          <form action="<?php echo FRONT_ROOT . "Reservation/RejectReservation" ?>" method="post">
                            <button type="submit" class="btn" name="reservationId" value=<?php echo $reservation->getId() ?>> Reject </button>
                          </form>
                        </td>
                      <?php } ?>
                    </tr>
                <?php }
                } ?>
                <?php
                if (!isset($counter) || $counter == 0) { ?>
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
                 <th style="width: 10%;">Dates</th>
              <!--<th style="width: 10%;">End Date</th> -->
                <th style="width: 12%;">Amount($)</th>
                <th style="width: 12%;">Observation</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $counterOwn = 0;
              foreach ($reservationList as $reservation) {

                if ($reservation->getOwner()->getId() == $_SESSION['loggedUser']->getId()) {

                  $counterOwn++;

              ?>
                  <tr>
                    <td><?php echo $reservation->getKeeper()->getName() . " " . $reservation->getKeeper()->getLastName() ?></td>
                    <td><?php echo $reservation->getPet()->getName() ?></td>
                    <td><?php foreach ($reservation->getDateList() as $date)
                    {echo $date->GetDate() . " ";}?></td>
                  
                    <td><?php echo $reservation->getAmount() ?></td>

                    <td style="width: 10%;">
                      <?php if ($reservation->getIsAccepted() == true) {
                        echo "Reservation Accepted";
                      } elseif ($reservation->getIsAccepted() === null) {
                        echo "Pending Keeper Confirmation";
                      }
                      else {
                        echo "Reservation Rejected";
                      }
                      ?>
                      <?php if ($reservation->getIsAccepted() === null) { ?>
                        <td style="width: 10%;">
                        <form action="<?php echo FRONT_ROOT . "Reservation/CancelReservation" ?>" method="post" >
                          <input type="hidden" value="<?php echo $reservation->getId(); ?>" name="reservationId"/>
                          <button type="submit" class="btn" value=""> Cancel </button>
                        </form>
                        </td>
                      <?php } ?>
                    </td>
                  </tr>


  <?php
                }
              } ?>
  <?php
  if (!isset($counterOwn) || $counterOwn == 0) { ?>
    <tr>
      <td colspan="8">You haven't placed any reservations yet!</td>
    </tr>

  <?php } ?>
  </tbody>
  </table>


      </div>
    </div>
    <?php if (isset($message) && $message!=="" && $message!==1 && $message!==2 && strpos($message,"-")==false){
                echo $message;
              }
              ?>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php
include('footer.php');
?>