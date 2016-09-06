<?php

Class ThemeGenerator
{
  public function __construct() {
    $this->themeName = isset( $_POST['themeName'] ) ? $_POST['themeName'] : null;
    $this->themeSlug = isset( $_POST['themeSlug'] ) ? $_POST['themeSlug'] : null;
    $this->themeFolderName = isset( $_POST['themeFolderName'] ) ? $_POST['themeFolderName'] : null;

    return $this;
  }

  public function search( $search, $replace, $file ) {
    // read the entire string
    $str = file_get_contents( $file );

    // replace something in the file string
    $str = str_replace( $search, $replace, $str );

    // write the entire string
    file_put_contents( $file, $str );
  }
}

?>