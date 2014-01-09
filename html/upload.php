<?php
function upload(){
  $ds = DIRECTORY_SEPARATOR;
  $storeFolder = 'uploads';

  if ( !empty($_FILES) ){
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname(__FILE__).$ds.$storeFolder.$ds;
    $targetFile = $targetPath.$_FILES['file']['name'];
    move_uploaded_file($tempFile, $targetFile);
  }

  return $targetFile
}

function getDoi($argc){
  // Create a new DOMDocument instance
  $dom = new DOMDocument;
  $dom->load($argc);

  // if the metadata's resource type is Document/Catalog/DisplayData/NumericalData, retrieve DOI
}

function insertIugonet(){
  echo "HOGE";
}

$targetFile=upload();
getDoi($targetFile);
insertIugonet();
?>
