<?php
include('header.php');
include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Add</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Keeper/ShowKeeperSetAvailability" ?>">Set Availability </a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="container clear">
    <div class="content">
      <div id="comments">
        <h2>MY PROFILE</h2>
        <form action="<?php echo  FRONT_ROOT . "" ?>" method="post" style="background-color: #EAEDED;padding: 2rem !important;">
          <table>
            <thead>
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Name</th>
                <th>Lastname</th>
                <th>Pet Size</th>
                <th>Price</th>
                <th>Availability</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><?php echo  $_SESSION['loggedUser']->getUserName() ?></td>
                <td><?php echo $_SESSION['loggedUser']->getEmail() ?></td>
                <td><?php echo $_SESSION['loggedUser']->getName() ?></td>
                <td><?php echo $_SESSION['loggedUser']->getLastName() ?></td>
                <td><?php echo $_SESSION['loggedUser']->getPetSize() ?></td>
                <td><?php echo $_SESSION['loggedUser']->getPrice() ?></td>
                <td><?php if ($_SESSION['loggedUser']->getAvailability() !== null)
                {
                  echo "Start Date: ";
                  echo $_SESSION['loggedUser']->getAvailability()->getStartDate(); 
                  echo ". End Date: ";
                  echo $_SESSION['loggedUser']->getAvailability()->getEndDate();
                  echo ". Days of Week: ";
                $arrayOfDays = $_SESSION['loggedUser']->getAvailability()->getDaysOfWeek();
                foreach($arrayOfDays as $day)
                {
                  echo $day . " ";
                }
              }
                else{ echo "There is no Availability set yet!";} ?></td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php
include('footer.php');
?>