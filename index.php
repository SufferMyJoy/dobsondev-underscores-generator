<?php
// PHP Autoload
include('autoloader.php');

$autoloader = new AutoLoader();
$themeGenerator = new themeGenerator();
$zip = new ZipArchive();

// PHP delete function that deletes all of the folders contents
// http://stackoverflow.com/questions/11613840/remove-all-files-folders-and-their-subfolders-with-php
function delete_files( $dir ) {
  if ( is_dir( $dir ) ) {
    $objects = scandir( $dir );
    foreach ( $objects as $object ) {
      if ( $object != "." && $object != ".." ) {
        if ( filetype( $dir . "/" . $object ) == "dir" ) {
          delete_files( $dir . "/" . $object) ;
        } else {
          unlink( $dir . "/" . $object );
        }
      }
    }
    reset( $objects );
  }
}

if ( $_POST ) {
  // House keeping to ensure we don't get bogged down
  delete_files( 'temp/' );

  // Get file from Github and put it in the temp folder
  file_put_contents( 'temp/master.zip', file_get_contents( 'https://github.com/SufferMyJoy/dobsondev-underscores/archive/master.zip' ) );

  $folder = 'temp/dobsondev-underscores-master/';

  // Extract file to folder in project
  if ( $zip->open( 'temp/master.zip', ZipArchive::CREATE && ZipArchive::OVERWRITE ) === TRUE ) {
    $zip->extractTo( 'temp/' );
    if ( $zip->close() !== TRUE ) {
      exit( 'Error closing master.zip' );
    }
  } else {
    exit( 'Cannot open master.zip' );
  }

  // Set path of original folder
  $path = $folder . '_s-original/';

  // Set name of new zip file
  $newZipFile = 'temp/' . $themeGenerator->themeFolderName . '.zip';

  // Create new zip file
  if ( $zip->open( $newZipFile, ZipArchive::CREATE && ZipArchive::OVERWRITE ) !== TRUE ) {
    exit( 'Cannot open the new zip' );
  }

  // Create iterator and turn it into an array
  $iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $path ), RecursiveIteratorIterator::SELF_FIRST );
  $files = iterator_to_array( $iterator, true );

  // Recursively replace _SsS with theme name and _sSs with theme slug
  foreach ( $files as $file => $info ) {
    if ( $info->isDir() === FALSE ) {
      $themeGenerator->search( '_SsS', $themeGenerator->themeName, $file );
      $themeGenerator->search( '_sSs', $themeGenerator->themeSlug, $file );
      $zip->addFile( $file, str_replace( $path, $themeGenerator->themeFolderName . '/', $file ) );
    }
  }

  // Close the new zip file
  if ( $zip->close() !== TRUE ) {
    exit( 'Error closing new zip file' );
  }

  // Record download in database for tracking
  $connection = mysqli_connect( '64.65.32.84', 'dobson_usr', 'GarrotingPer5onate', 'dobson_db' );
  // Check if we can connect to database
  if ( mysqli_connect_errno( $connection ) ) {
    // Error connecting to database
    error_log('Connection Error : ' . mysqli_connect_error());
    mysqli_close( $connection );
  } else {
    // No error connecting to database
    // Make SQL statement
    $sql = "INSERT INTO dobsondev_underscores_downloads (ip_address) VALUES (?)";
    // Test if SQL statement is valid
    if ( ! $statement = mysqli_prepare( $connection, $sql ) ) {
      // SQL statement is not valid
      error_log('SQL Error : ' . mysqli_connect_error());
      mysqli_close( $connection );
    } else {
      // SQL statement is valid
      $ip_address = $_SERVER['REMOTE_ADDR'];
      mysqli_stmt_bind_param( $statement, 's', $ip_address );
      mysqli_stmt_execute( $statement );
      mysqli_stmt_close( $statement );
      mysqli_close( $connection );
    }
  }

  header("Content-Type: application/zip");
  header("Content-Disposition: attachment; filename=" . $themeGenerator->themeFolderName . ".zip");
  header("Content-Length: " . filesize( $newZipFile ) );
  readfile( $newZipFile );

  exit();
}

?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DobsonDev Underscores Theme Generator</title>
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
  </head>

  <body>
    <div class="row">
      <div class="small-8 small-centered columns">
        <img src="imgs/DobsonDev-Underscores.png" title="DobsonDev Underscores WordPress Theme" alt="dobsondev underscores wordpress theme" />
      </div><!-- .small-12 columns -->
      <br />
      <br />

      <div class="small-12 medium-5 columns">
        <h2>Generate Theme</h2>
        <p>
          You can create a downloadable zip file for your theme by using the form below:
        </p>
        <form name="theme_form" method="POST">
          <label>Theme Name
            <input type="text" name="themeName" placeholder="Theme Name" />
          </label>
          <label> Theme Slug
            <input type="text" name="themeSlug" placeholder="Theme Slug" />
          </label>
          <label> Theme Folder
            <input type="text" name="themeFolderName" placeholder="Theme Folder Name" />
          </label>
          <input class="button" type="submit" name="submitForm" value="Generate Theme" />
        </form>
      </div><!-- .small-12 .medium-4 medium-offset-2 columns -->

      <div class="small-12 medium-6 medium-offset-1 columns">
        <h2>DobsonDev Underscores</h2>
        <p>
          This starting WordPress theme is based on <a href="http://underscores.me/" title="Underscores WordPress theme" target="_blank">Underscores</a> with <a href="http://foundation.zurb.com/" title="Foundation Front-end Framework" target="_blank">Foundation</a> hooked in for styling. You can create the theme from this web page using the form to the left. You can then install it just like any other WordPress theme.
        </p>
        <h3>GitHub</h3>
        <p>
          You can also download the source code for the project from <a href="https://github.com/SufferMyJoy/dobsondev-underscores" title="DobsonDev Underscores GitHub" target="_blank">GitHub</a>. In the source code you will find two shell scripts, one for OS X and one for Linux. You can install these shell scripts on your server to make generating the theme even faster.
        </p>
        <p>
          Instructions for installing and running the shell scripts can be found in the <a href="https://github.com/SufferMyJoy/dobsondev-underscores/blob/master/README.md" title="DobsonDev Underscores Readme File" target="_blank">README</a> file.
        </p>
        <h3>License</h3>
        <p>
          DobsonDev Underscores is licensed under the <a href="https://github.com/SufferMyJoy/dobsondev-underscores/blob/master/LICENSE" title="DobsonDev Underscores MIT License" target="_blank">MIT License</a>.
        </p>
      </div><!-- .small-12 .medium-6 .medium-offset-1 columns -->
    </div><!-- .row -->

    <footer class="text-center">
      &copy; Copyright <?php echo date('Y'); ?> DobsonDev All Rights Reserved &nbsp; | &nbsp; Website Design &amp; Development by <a href="http://dobsondev.com/" alt="DobsonDev | Web Development, Cooking and Coding">DobsonDev</a>
    </footer>

    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/vendor/foundation.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>