<?php include("include_files/header.php"); ?>

	 
<?php include("include_files/nav.php"); ?>


	<div class="jumbotron">
		<h1 class="text-center"> 
		   <?php
              if(logged_in()){

				 echo "<h1>Welcome to Admin Page!</h1>";

			  }else{

				  redirect("index.php");
			  }

		   ?>
		</h1>
	</div>


<?php include("include_files/footer.php"); ?>