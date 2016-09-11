<?php
session_start();
require_once './php/db_connect.php';
require_once "php/functions.php";
if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

if(isset($_POST['text']))
{
    $name = $_SESSION['username'];
    $text = sanitizeString($db, $_POST['text']);

    $time = $_SERVER['REQUEST_TIME'];
	$file_name = $time . '.jpg';

    if (empty($_POST['filter'])) {  // check if filter selected
      $img_filter = 'none';         // assign filter value none if not specified
  } else {                        // otherwise check which filter is applied
      $filter_value = $_POST['filter'];
      if ($filter_value === 'myNostalgia'){
          $img_filter = 'saturate(40%) grayscale(100%) contrast(45%) sepia(100%)';
      } elseif ($filter_value === 'grayscale'){
          $img_filter = 'grayscale(100%)';
      } elseif ($filter_value === 'saturate'){
          $img_filter = 'saturate(700%)';
      } elseif ($filter_value === 'sepia'){
          $img_filter = 'sepia(100%)';
      } else {
          $img_filter = 'none';
      }

  }

    if ($_FILES)
    {
        $tmp_name = $_FILES['upload']['name'];
        $dstFolder = 'users';
        move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $file_name);
        //echo "Uploaded image '$file_name'<br /><img src='$dstFolder/$file_name'/>";
    }

    SavePostToDB($db, $name, $text, $time, $file_name, $img_filter);
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

    <link rel="stylesheet" href="css/styles.css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
    <div class="container">
        <div class="page-header">
          <h1><center><?php echo "<p>Signed in as " . $_SESSION['username']  . "!</p>" ?></center></h1>
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
                <li><a href="#">Wall</a></li>
                <li><a href="index.php">Upload</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Log Out</a></li>
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </div>
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <?php echo getPostcards($db); ?>
                </div>
            </div>

        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/masonry-layout@4.1/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(window).on('load', function(){
            $('div.col-md-12').masonry();
        });
    </script>
</body>



<?php $db->close(); ?>
