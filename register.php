<?php include("include_files/header.php"); ?>

	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Login App</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">

            <li><a href="index.php">Home</a></li>
     
          </ul>


          
		  <ul class="nav navbar-nav navbar-right">
            
            <li ><a href="logout.php">Logout</a></li>
     
          </ul>



        
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
<div class="container">

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
		
		<?php register_user_validate(); ?>
								
		</div>



	</div>
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="login.php">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="register.php" class="active" id="">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="register-form" method="post" role="form" enctype="multipart/form-data">
                                    
								    <div class="form-group">
						                <label for="fullname">Fullname :</label>
										<input type="text" name="fullname" id="fullname" tabindex="1" class="form-control" placeholder="Fullname" value="">
									</div>
									<div class="form-group">
								    	<label for="username">Username :</label>
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
									    <label for="email">Email Address :</label>
										<input type="email" name="email" id="register_email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
									    <label for="password">Password :</label>
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
									    <label for="confirm_password">Confirm Password :</label>
										<input type="password" name="confirm_password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script> 
			const errors = document.querySelectorAll('.error');
			  errors.forEach(error => {
				error.addEventListener('click', e => {
					error.remove();
				});
			});
		</script>

<?php include("include_files/footer.php"); ?>