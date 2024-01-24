<?php
include_once("includes/logged.php");
include_once("includes/dbConnection.php");

$statusFlag = false;
if (isset($_GET["id"])){
	$id = $_GET["id"];
	$statusFlag = true;
}else if($_SERVER["REQUEST_METHOD"] === "POST"){
	try{
		$id=$_POST["id"];
		$NewsDate = $_POST["news-date"];
		$Title = $_POST["title"];
		$Content = $_POST["content"];
		$Author = $_POST["author"];
		$Active = $_POST["active"];
		$Category = $_POST["category"];

		if($_POST["active"]){
		  $Active =1 ;
		}else{
		  $Active =0 ;
		}

		$oldImage=$_POST["oldImage"];
		include_once("includes/editImage.php");
	   
		
		$sql = "UPDATE `news` SET `newsDate`=?,`title`=?,`content`=?,`author`=?,`active`=?,`image`=?,`category`=? WHERE id=?";
		$stmt=$conn->prepare($sql);
		$stmt->execute([$NewsDate, $Title, $Content, $Author, $Active, $image_name, $Category,$id]);
	  }catch(PDOException $e){
		  echo "Connection failed" . $e->getMessage();
	  }

}

if($statusFlag){
	try{
		
		$sql = "SELECT * FROM `news` WHERE id =?";
		$stmt=$conn->prepare($sql);
		$stmt->execute([$id]);
		$row = $stmt->fetch();

		$Date = $row["newsDate"];
		$NewsDate = date( 'Y-m-d',strtotime($Date));
		
		$Title = $row["title"];
		$Content = $row["content"];
		$Author = $row["author"];
		$Image = $row["image"];
		$ActiveStatus = $row["active"];  
		if ($ActiveStatus){
		$Active ="checked";
		} else{
		$Active ="";
		} 
		
		$CategoryStatus = $row["category"];
		


	}catch(PDOException $e){
		echo "Connection failed" . $e->getMessage();
	}
}

    $sql = "SELECT * FROM `categoryTable`";
	$stmtCategory = $conn-> prepare($sql);
	$stmtCategory-> execute();
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>News Admin | Edit News</title>

	<!-- Bootstrap -->
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->
	<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">
					<div class="navbar nav_title" style="border: 0;">
						<a href="../index.php"class="site_title"><i class="fa fa-newspaper-o"></i> <span>News Admin</span></a>
					</div>

					<div class="clearfix"></div>

					<!-- menu profile quick info -->
					<?php
					include_once("includes/menuProfile.php");
					?>
					<!-- /menu profile quick info -->

					<br />

					<!-- sidebar menu -->
					<?php
					include_once("includes/sideBarMenue.php");
					?>
					<!-- /sidebar menu -->

					<!-- /menu footer buttons -->
					<div class="sidebar-footer hidden-small">
						<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="login.php">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
				</div>
			</div>

			<!-- top navigation -->
			<?php
            include_once("includes/topNavigationBar.php");
            ?>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">
					<div class="page-title">
						<div class="title_left">
							<h3>Manage News</h3>
						</div>

						<div class="title_right">
							<div class="col-md-5 col-sm-5  form-group pull-right top_search">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button">Go!</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 ">
							<div class="x_panel">
								<div class="x_title">
									<h2>Edit News</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a class="dropdown-item" href="#">Settings 1</a>
												</li>
												<li><a class="dropdown-item" href="#">Settings 2</a>
												</li>
											</ul>
										</li>
										<li><a class="close-link"><i class="fa fa-close"></i></a>
										</li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<br />
									<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ;?>" enctype="multipart/form-data" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="News-date">News Date <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="date" id="News-date"  required="required" class="form-control " value="<?php echo $NewsDate ?>" name="news-date">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Title <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<input type="text" id="title" required="required" class="form-control"  value="<?php echo $Title ?>" name="title">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="content">Content <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<textarea id="content" name="content" required="required" class="form-control"><?php echo $Content ?></textarea>
											</div>
										</div>
										<div class="item form-group">
											<label for="author" class="col-form-label col-md-3 col-sm-3 label-align">Author <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 ">
												<input id="author" class="form-control" type="text" name="author" required="required" value="<?php echo $Author ?>">
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align">Active</label>
											<div class="checkbox">
												<label>
												    <input type='hidden'    value="0"   name="active"> <?php // To Avoid warning when UnChecked chechbox is sent?>
													<input type="checkbox" class="flat" name="active" <?php echo $Active ?>>
												</label>
											</div>
										</div>
										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="image">Image <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">

											    <input type="file" id="image" name="image"  class="form-control">
												<img src="../img/<?php echo $Image ?>" alt="<?php echo $Title ?>" style="width:300px;">
											</div>
										</div>

										<div class="item form-group">
											<label class="col-form-label col-md-3 col-sm-3 label-align" for="title">Category <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 ">
												<select class="form-control" name="category" id="">
													<option value=" ">Select Category</option>

													
													<?php
															foreach($stmtCategory->fetchAll() as $row){
															$categoryName = $row["categoryName"];
															$categoryId =    $row["id"];
															if($categoryId == $CategoryStatus ){
																$selected="selected";
															}
															else{
																$selected="";
															}							
															?>
															<option value="<?php echo $categoryId?>"  <?php echo $selected?> ><?php echo $categoryName ?></option>
															<?php
																}
															?>	
												</select>
											</div>
										</div>
										<div class="ln_solid"></div>
										<div class="item form-group">
											<div class="col-md-6 col-sm-6 offset-md-3">
												<a href="News.php"><button class="btn btn-primary" type="button">Cancel</button></a>
												<button type="submit" class="btn btn-success">Add</button>
											</div>
										</div>
										<input type="hidden" name="id"  value= "<?php echo $id //sending id to be used in UPDATE SQL ?>">
										<input type="hidden" name="oldImage" value= "<?php echo $Image?>">
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- /page content -->

			<!-- footer content -->
			<footer>
				<div class="pull-right">
					Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
		</div>
	</div>

	<!-- jQuery -->
	<script src="vendors/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- FastClick -->
	<script src="vendors/fastclick/lib/fastclick.js"></script>
	<!-- NProgress -->
	<script src="vendors/nprogress/nprogress.js"></script>
	<!-- bootstrap-progressbar -->
	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- bootstrap-wysiwyg -->
	<script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
	<script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
	<script src="vendors/google-code-prettify/src/prettify.js"></script>
	<!-- jQuery Tags Input -->
	<script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
	<!-- Switchery -->
	<script src="vendors/switchery/dist/switchery.min.js"></script>
	<!-- Select2 -->
	<script src="vendors/select2/dist/js/select2.full.min.js"></script>
	<!-- Parsley -->
	<script src="vendors/parsleyjs/dist/parsley.min.js"></script>
	<!-- Autosize -->
	<script src="vendors/autosize/dist/autosize.min.js"></script>
	<!-- jQuery autocomplete -->
	<script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
	<!-- starrr -->
	<script src="vendors/starrr/dist/starrr.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>

</body></html>
