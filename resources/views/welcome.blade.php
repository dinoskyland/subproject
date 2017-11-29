
        
            <div class="login-box">
              <div class="login-logo">
              <a href="../../index2.html"><b>E-TOOLS</b></a>
              </div>
              <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
<!--"resources/pages/login/login.php"-->
    <form action="resources/pages/login/login.php" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Username">
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" value="Submit" name="submit">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="{{route('userList')}}">User view link</a><br>
    <!--"register.html"-->
    <a href="{{route('user')}}" class="text-center">Product feature view link</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->