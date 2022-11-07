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
        <li><a href="#">Show</a></li>
        <li><a href="#">List - Remove</a></li>
      </ul> -->
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>ADD NEW PET</h2>
        <form action="<?php echo  FRONT_ROOT."Reservation/Add"?>" method="post" enctype="multipart/form-data" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Pet Name</th>
                <th>Species</th>
                <th>Breed</th>
                <th>Size</th>
                <th>Keeper</th>
                <th>Total Price</th>
                
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <?php echo $pet->GetName()?>
                </td>
                <td>
                <?php echo $pet->getPetSpecies()?> 
                </td>
                <td>
                  <?php echo $pet->getBreed()?>
                </td>     
                <td>
                <?php echo $pet->getSize()?>
                </td>
                <td>
                  <?php echo $keeper->getName() . " " . $keeper->getLastName()?>
                </td>         
                <td>
                  <?php echo $keeper->getPrice() * count($dateStringArray)?>
                </td>   
                <td>
                  <form action="Reservation/add" method="post">
                  <input type="hidden" value="<?php echo $keeper; ?>" name="keeper"/>
                  <input type="hidden" value="<?php echo $pet;?>" name="pet"/>
                  <input type="hidden" value="<?php echo $dateStringArray;?>" name="dateStringArray"/>
                  
                  <button type="submit" class="btn" value=""> Confirm Reservation </button>
                  </form>
                </td>        
                     
              </tr>
              </tbody>
          </table>
          
        </form>

        <?php if ($message!==""){
                echo $message;
              }
              ?>

      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php 
  include('footer.php');
?>