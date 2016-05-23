      <div class="row">
          
        <div class="col-md-5">
          <h2>Log In</h2>
          <p>Use your current Log-in data to log in. If you don't have one then form at the right section is for you</p>
          
          <?php 
            if (!empty($errors1))
            {
                echo "<div class=\"alert alert-danger\" role=\"alert\">$errors1</div>";
            }
          ?>
          
          <form class="form-horizontal" method="POST">
            <input type="hidden" name="type" value="login">
            <div class="form-group">
              <label for="login-email" class="col-sm-4 control-label">Email</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" id="login-email" name="login-email" required placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="login-password" class="col-sm-4 control-label">Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="login-password" name="login-password" required placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default btn-lg">
                  <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                  Sign in</button>
              </div>
            </div>
          </form>
        </div>
        
        <div class="col-md-2"><h2>or</h2></div>
          
        <div class="col-md-5">

          <h2>Registrer</h2>
          <p>If you don't have account yet you could spend few seconds on registration form below:</p>
          
          <?php if (empty($warnings)): ?>
          
          <?php 
            if (!empty($errors2))
            {
                echo "<div class=\"alert alert-danger\" role=\"alert\">$errors2</div>";
            }
          ?>
          
          <form class="form-horizontal" method="POST">
            <input type="hidden" name="type" value="register">
            <div class="form-group">
              <label for="reg-name" class="col-sm-4 control-label">Name</label>
              <div class="col-sm-8">
                <input class="form-control" id="reg-name" name="reg-name" required placeholder="Name">
              </div>
            </div>
            <div class="form-group">
              <label for="reg-email" class="col-sm-4 control-label">Email</label>
              <div class="col-sm-8">
                <input type="email" class="form-control" id="reg-email" name="reg-email" required placeholder="Email">
              </div>
            </div>
            <div class="form-group">
              <label for="reg-password" class="col-sm-4 control-label">Password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="reg-password" name="reg-password" required placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <label for="reg-password2" class="col-sm-4 control-label">Retype password</label>
              <div class="col-sm-8">
                <input type="password" class="form-control" id="reg-password2" name="reg-password2" required placeholder="Password again">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default btn-lg">
                  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                  Register</button>
              </div>
            </div>
          </form>
          
          <?php else: ?>
          
            <div class="alert alert-success" role="alert"><?= $warnings; ?></div>
          
          <?php endif; ?>
          
        </div>
        
      </div>