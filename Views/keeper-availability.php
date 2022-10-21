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





<!-- CURRENTLY NOT IN USE -->





<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>SET AVAILABILITY</h2>
        <form action="<?php echo  FRONT_ROOT."Keeper/Add "?>" method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Initial Date</th>
                <th>Final Date</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="date" min ='<?php echo date('Y-m-d');?>' name="initialDate" size="20" required>
                </td>
                <td>
                  <input type="date" name="finalDate" min ='<?php echo date('Y-m-d');?>' size="20" required>
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