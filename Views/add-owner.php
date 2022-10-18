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
        <h2>ADD NEW OWNER</h2>
        <form action="<?php echo  FRONT_ROOT."Owner/Add "?>" method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Name</th>
                <th>Lastname</th>
                <th>Avatar Picture</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="email" name="email" size="20" required>
                </td>
                <td>
                  <input type="text" name="userName" size="15" required>
                </td>
                <td>
                  <input type="password" name="password" size="20" required>
                </td>     
                <td>
                  <input type="text" name="name" size="20" required>
                </td>         
                <td>
                  <input type="text" name="lastName" size="20" required>
                </td>         
                <td>
                  <input type="text" name="avatar" size="3" required>
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