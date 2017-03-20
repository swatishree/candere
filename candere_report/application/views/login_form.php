
<div class="container">
  <div id="login-form">
    <h3>Login</h3>
    <fieldset>
      <form action="<?php echo base_url(); ?>index.php/login/index" method="post" name='process'>
        <input type="email" required placeholder="Email" name='email' id='email' value="<?php echo set_value('email'); ?>" >
        <input type="password" required placeholder="Password" name='password' id='password' value="<?php echo set_value('password'); ?>" > 
        <input type="submit" value="Login" class="styled-button-1" style="float: right;margin-top: 20px;">
      </form>
    </fieldset>
  </div> <!-- end login-form -->
</div>