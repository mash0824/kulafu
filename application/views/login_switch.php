<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Switch Inventory System | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/switch/switch.css') ?>">
</head>
<body>
<div class="container">
	<div class="row loginrow">
		<div class="col-md-6 hidden-sm hidden-xs"><img src="<?php echo base_url('assets/images/site/login-illustration.png') ?>" class="img-responsive logo-center" /></div>
		<div class="col-md-6 col-sm-12">
			<div class="login-box">
              <div class="login-logo">
                Welcome to
              </div>
              <!-- /.login-logo -->
              <div class="login-box-body">
                <h1>Switch Inventory Tracking System</h1>
                <?php if(!empty(validation_errors()) || !empty($errors)) { ?>
                <div class="alert"><?php echo validation_errors(); ?>  
                <?php if(!empty($errors)) {
                  echo $errors;
                } ?></div>
                <?php } ?>
                <form action="<?php echo base_url('auth/login') ?>" method="post">
                  <div class="form-group has-feedback">
                  	<label>Username
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" autocomplete="off">
                    </label>
                  </div>
                  <div class="form-group has-feedback">
                  	<label>Password
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" autocomplete="off">
                    </label>
                  </div>
                  <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-pull-4 col-xs-4 col-xs-push-4">
                      <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
                    </div>
                    <div class="col-xs-12">
                    	Forgot your password? <a href="<?php echo site_url();?>auth/forgot">Go here</a>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
            
              </div>
              <!-- /.login-box-body -->
            </div>
            <!-- /.login-box -->
			
			
		</div>
	</div>
</div>


<!-- jQuery 3 -->

<script src="<?php echo base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>