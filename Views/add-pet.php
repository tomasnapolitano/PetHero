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
        <h2>ADD NEW DOG</h2>
        <form action="<?php echo  FRONT_ROOT."Dog/Add "?>" method="post" enctype="multipart/form-data" style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Dog Name</th>
                <th>Species</th>
                <th>Breed</th>
                <th>Size</th>
                <th>Vaccine Plan</th>
                <th>Vaccine Plan Observations</th>
                <th>Picture</th>
                <th>Video</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="text" name="name" size="20" required>
                </td>
                <td>
                <select name="petSpecies" required>
                    <option value="1">Dog</option> 
                </select> 
                </td>
                <td>
                  <input type="text" name="breed" size="20" required>
                </td>     
                <td>
                <select name="size" required>
                    <option value="small">Small</option> 
                    <option value="medium">Medium</option> 
                    <option value="Large">Large</option>
                </select> 
                </td>
                <td>
                  <input type="file" name="vacPlan" />
                </td>         
                <td>
                <textarea name="vacObs" cols="45" rows="3"></textarea>
                </td>   
                <td>
                  <input type="file" name="picture" />
                </td>        
                <td>
                  <input type="file" name="video" />
                </td>         
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
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