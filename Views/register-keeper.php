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
        <li><a href="#">List - Remove</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>BE A KEEPER!</h2>
        <form action="<?php echo  FRONT_ROOT."Keeper/Add "?>" method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Size</th>
                <th>Price</th>
                <th>Availability</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <!--<input type="text" name="petSize" size="20" required>-->
                  <select name="petSize" required>
                    <option value="small">Small</option> 
                    <option value="medium">Medium</option> 
                    <option value="Large">Large</option>
                </select> 
                </td>
                <td>
                  <input type="text" name="price" size="15" required>
                </td>
                <td>
                  <input type="text" name="availability" size="20" required>
                </td>           
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php 
  include('footer.php');
?>