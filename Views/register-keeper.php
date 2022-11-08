<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
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
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days of Week</th>
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
                  <input type="number" min="1" max="1000000" name="price" size="15" required>
                </td>         
                <td>
                  <input type="date" name="startDate" min="<?php echo date('Y-m-d') ?>" required>
                </td>         
                <td>
                  <input type="date" name="endDate" min="<?php echo date('Y-m-d') ?>" required>
                </td>         
                <td>
                <input type="checkbox" id="monday" name="daysOfWeek[]" value="Monday" />
                <label for="monday">Monday</label>
                <input type="checkbox" id="tuesday" name="daysOfWeek[]" value="Tuesday" />
                <label for="tuesday">Tuesday</label>
                <input type="checkbox" id="wednesday" name="daysOfWeek[]" value="Wednesday" />
                <label for="wednesday">Wednesday</label>
                <input type="checkbox" id="thursday" name="daysOfWeek[]" value="Thursday" />
                <label for="thursday">Thursday</label>
                <input type="checkbox" id="friday" name="daysOfWeek[]" value="Friday" />
                <label for="friday">Friday</label>
                <input type="checkbox" id="saturday" name="daysOfWeek[]" value="Saturday" />
                <label for="saturday">Saturday</label>
                <input type="checkbox" id="sunday" name="daysOfWeek[]" value="Sunday" />
                <label for="sunday">Sunday</label>


                <!-- Code below does not render the select list properly in Chrome or IE -->
                  <!--<select name="daysOfWeek[]" id="daysOfWeek" multiple="multiple" required>Days of Week
                  <option value="monday">Monday</option>
                  <option value="tuesday">Tuesday</option>
                  <option value="wednesday">Wednesday</option>
                  <option value="thursday">Thursday</option>
                  <option value="friday">Friday</option>
                  <option value="saturday">Saturday</option>
                  <option value="sunday">Sunday</option>-->
                  </select>
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