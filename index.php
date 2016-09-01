<?php
session_start();
require_once './php/db_connect.php';
require_once "php/functions.php";
if(!isset($_SESSION['id'])){
    header("Location: login.php");
}
 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Image uploader</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./css/styles.css"/>
    <script src="uploadscript.js"></script>

</head>
<body>
    <body onload="initialize();">
      <div class="container">
        <div class="page-header">
          <h1><center>Upload Page</center></h1>
        </div>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="wall.php">Wall</a></li>
                <li><a href="#">Upload</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Log Out</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
		<div class="row">
			<div id="formParent" class="col-md-6 col-md-offset-3">
				<form id="form" class="form-horizontal" method="POST" action="wall.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="sr-only" for="image">Original Image</label>
                        <img id="image" name="image" src="http://lorempixel.com/400/200/" width="50%" height="50%">
                        <input type="file" id="upload" name="upload" accept="image/*">
                    </div>
                    <div class="form-group" id="filtervalue">
                        <h3><center>Available Filters</center></h3>
                        <div class="checkbox-inline">
                            <label for="myNostalgia">Nostalgia</label>
                            <input type="radio" name="filter" id="myNostalgia" value="myNostalgia" onclick="applyMyNostalgiaFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="grayscale">Grayscale</label>
                            <input type="radio" name="filter" id="grayscale" value="grayscale" onclick="applyGrayscaleFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="grayscale">Sepia</label>
                            <input type="radio" name="filter" id="sepia" value="sepia" onclick="applySepiaFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="grayscale">Saturate</label>
                            <input type="radio" name="filter" id="saturate" value="saturate" onclick="applySaturateFilter();">
                        </div>
                        <div class="checkbox-inline">
                            <label for="original">Original</label>
                            <input type="radio" name="filter" id="lomo" value="lomo" onclick="revertToOriginal();">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-11">
                            <textarea class="form-control" id="text" name="text" maxlength="140" placeholder="140 characters" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary start">
                      <i class="glyphicon glyphicon-upload"></i>
                      <span>Start upload</span>
                    </button>
				</form>
			</div>
		</div>
	</div>

    	<!-- JavaScript placed at bottom for faster page loadtimes. -->
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>

    	<!-- Latest compiled and minified JavaScript -->
    	<script src="js/bootstrap.min.js"></script>

    	<script src="functions.js"></script>

    </body>
</html>
