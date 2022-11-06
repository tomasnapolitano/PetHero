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
      <!--s<ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul>-->
    </div>
  </div>
</div>




<!-- IMPLEMENTAR VISTA PARA VER KEEPERS DESDE UN OWNER -->




<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <div class="content"> 
      <div class="scrollable">
      <form autocomplete="off" action="<?php echo FRONT_ROOT . "Owner/ShowKeeperListView" ?>" method="post">


     <section class="container">
        <h3 class="pt-4 pb-2">Search Keepers!</h3>
        <form >
            <div class="row form-group">
                <label for="date" class="col-sm-1.5 col-form-label">Select Dates</label>
                <div class="col-sm-4">
                    <div class="input-group date"  name="date" id="datepicker">
                        <input type="text"  name="date" class="form-control">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white">
                                <i class="fa fa-calendar"  name="date"></i>
                            </span>
                        </span>
                    </div>

                    <br>

                <div class="row form-group">
                  <label for="pets" class="col-sm-1.5 col-form-label">Select Pet:</label>
                  <div class="input-group pets">
                    <select name="pets" required>

                    <?php 
                    $counter = 0;
                      foreach ($petList as $pet)
                      {
                        if ($pet->GetOwnerId() == $_SESSION['loggedUser']->GetId())
                        {
                          $counter++; ?>

                          <option value="<?php echo $pet->GetId()?>"> <?php echo $pet->GetName() . ' (' . $pet->getPetSpecies() .')'; ?> </option>
                        <?php
                        }
                      }
                      if ($counter == 0)
                      {
                        ?> <option value="0"> <?php echo "You haven't added any pets yet!"; ?> </option> <?php
                      }
                    ?>
                    
                    </select> 
                  </div>
                </div>
                </div>
                <button type="submit" class="btn" value=""> Search! </button>
            </div>
        </form>
    </section>

    <!-- <?php echo $_POST['date'];?>
    <?php echo $_POST['pets'];?> -->

    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                lan:'en',
                multidate: true
            });
        });
    </script>

        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">Name</th>
              <th style="width: 10%;">Pet Size</th>
              <th style="width: 15%;">Price</th>
              <th style="width: 30%;">Availability</th>
            </tr>
          </thead>
          <tbody>
          <?php // ---------------------------------------- If a date and pet are entered: (filters keepers by date)
          $keepersToShow = 0;

          if (isset($_POST['date']) && isset($_POST['pets']))
          {
            echo $_POST['date'];
            echo $_POST['pets'];

            $string = $_POST['date'];

            $dateStringArray = explode(',',$string);

            foreach ($keepersList as $keeper) {
              if($keeper->getUserRole() == 2){
                $counterAux=0;
                foreach ($dateStringArray as $dateString) // cycling through the chosen dates to search
                {
                  $flag = 0;
                  foreach ($keeper->getDateArray() as $date)
                  {
                    if ($date->getDate() === $dateString && $date->getStatus() === 'Available')
                    {
                      $flag = 1;
                      $counterAux++;
                      break;
                    }
                  }
                  if ($flag=0)
                  {
                    break;
                  }
                }
                if ($counterAux == count($dateStringArray)){
                  $keepersToShow++;
          ?>    <tr>
                  <td><?php echo $keeper->getname() . ' ' . $keeper->getLastName()?></td>
                  <td><?php echo $keeper->getPetSize() ?></td>
                  <td><?php echo $keeper->getPrice() ?></td>
                  <td><?php echo $keeper->getAvailability()->getStartDate() . ' to ' ?>
                  <?php echo $keeper->getAvailability()->getEndDate() ?>
                  <?php foreach ($keeper->getAvailability()->getDaysOfWeek() as $day)
                  {
                    echo $day . " "; 
                    
                  }?></td>
                <!-- <td>
                  <button type="submit" class="btn" value=""> Remove </button>
                </td> -->
              </tr><?php
              }}
            }

          }else{ // ---------------------------------------- if no date or pet is entered: (shows all keepers)
            foreach ($keepersList as $keeper) {
              if($keeper->getUserRole() == 2){
                $keepersToShow++;
                
          ?>    <tr>
                  <td><?php echo $keeper->getname() . ' ' . $keeper->getLastName()?></td>
                  <td><?php echo $keeper->getPetSize() ?></td>
                  <td><?php echo $keeper->getPrice() ?></td>
                  <td><?php echo $keeper->getAvailability()->getStartDate() . ' to ' ?>
                  <?php echo $keeper->getAvailability()->getEndDate() ?>
                  <?php foreach ($keeper->getAvailability()->getDaysOfWeek() as $day)
                  {
                    echo $day . " "; 
                    
                  }?></td>
                <!-- <td>
                  <button type="submit" class="btn" value=""> Remove </button>
                </td> -->
              </tr><?php
              }
            }}
            
            if ($keepersToShow == 0)
            { ?>
              <tr>
                  <td colspan="4">There are no Keepers available right now :(</td>
              </tr> 
                           <?php
            }
            ?> 
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