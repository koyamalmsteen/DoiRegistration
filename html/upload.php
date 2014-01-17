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

function insertIntoIugonetTable(){
  echo "HOGE";
}

function errorHandling($errorNo){
  // delete file;  
  switch ($errorNo) {
  case 1:
    fputs(STDERR,"checkFileType() error!");
    break;
  case 2:
    fputs(STDERR,"validateXML() error!");
    break;
  case 3:
    fputs(STDERR,"checkDoiPrefix() error!");
    break;
  case 4:
    fputs(STDERR,"insertIntoIugonetTable() error!");
    break;
  default:
    fputs(STDERR,"Unknown erroNo!");
  }
  // print error message;
}

function checkFileType(){

}

function validateXML(){

}

function checkDoiPrefix(){

}

$targetFile=upload();
checkFileType();
getDoi($targetFile);
insertIntoIugonetTable();
?>
