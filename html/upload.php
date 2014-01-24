<?php
$targetPath = '';
$targetFile = '';
$doi = '';
$dom = '';

function upload(){
  global $targetPath, $targetFile;

  $ds = DIRECTORY_SEPARATOR;
  $storeFolder = 'uploads';

  if ( !empty($_FILES) ){
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname(__FILE__).$ds.$storeFolder.$ds;
    $targetFile = $targetPath.$_FILES['file']['name'];
    move_uploaded_file($tempFile, $targetFile);
  }

  return 0;
}

function checkFileType(){
  global $targetFile;

  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $fp = fopen("/tmp/test","w+");
  fwrite($fp, finfo_file($finfo,$targetFile));
  fclose($fp);

  if( finfo_file($finfo, $targetFile) != "application/xml"){
    errorHandling(__FUNCTION__, '');
  }
}

function readXML(){
  global $targetFile;
  global $dom;

  $dom = new DOMDocument();
  $dom->load($targetFile);
}

function validateXML(){
  global $dom;
  /*
  if( !$dom->schemaValidate('http://www.iugonet.org/data/schema/iugonet-2_2_2_4.xsd') ){
    errorHandling(__FUNCTION__, '');
  }else{

  }*/
}

function getDoi(){
  global $targetFile;
  global $doi;
  global $dom;

  // if the metadata's resource type is Document/Catalog/DisplayData/NumericalData, retrieve DOI
  $doi = '10.1234/4567';
}

function insertIntoIUGONET(){
  global $targetFile;
  global $doi;

  $link = mysql_connect('localhost','insertOnlyUser','pass');
  if (!$link){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $db_selected = mysql_select_db('wdsj', $link);
  if (!$db_selected){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $query = "INSERT INTO doc VALUES('".$doi."',1,1,1,'".$xml."')";
  $fp = fopen("/tmp/test5","w+");
  fwrite($fp, $query);
  fclose($fp);
  $result = mysql_query($query);
  if (!$result) {
    errorHandling(__FUNCTION__, mysql_error());
  }
}

function transform($into){
  global $targetFile;
  global $doi;

  if( $into!="jalc" and $into!="html" ){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $link =   $link = mysql_connect('localhost','insertOnlyUser','pass');
  if (!$link){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $db_selected = mysql_select_db('wdsj', $link);
  if (!$db_selected){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $jarFilePath = "saxon/lib/saxon9he.jar";

  $query = "";
  if( $into=="jalc" ){
    $output = "jalc.xml"
    $query = "INSERT INTO doc VALUES('".$doi."',1,1,2,'".$xml."')";
    $cmd = escapeshellcmd("java -jar".$jarFilePath."-o ".$output." -xsd -xsl iugonet2jalc.xsl -xslversion 2 ");
    $result = shell_exec($cmd);
    if($result){
      echo $result;
    }else if($result==false){
      echo "NG";
    }

    $fp = fopen("/tmp/test6","w+");
    fwrite($fp, $query);
    fclose($fp);
  }else if( $into=="html" ){
    $output = "index.html"
    $query = "INSERT INTO doc VALUES('".$doi."',1,1,3,'".$xml."')";
    $cmd = escapeshellcmd("java -jar".$jarFilePath."-o ".$output." -xsd -xsl iugonet2html.xsl -xslversion 2 ");
    $result = shell_exec($cmd);
    if($result){
      echo $result;
    }else if($result==false){
      echo "NG";
    }

    $fp = fopen("/tmp/test7","w+");
    fwrite($fp, $query);
    fclose($fp);
  }

  $result = mysql_query($query);
  if (!$result) {
    errorHandling(__FUNCTION__, mysql_error());
  }

}

function errorHandling($errorFunctionName, $comment){
  // delete file;  

  $fp = fopen("/tmp/test2","w+");
  fwrite($fp, $errorFunctionName."() error!");
  fclose($fp);
  // print error message;

  die('[WDSJ] Database Selection Error'.$errorFunctionName);

}

function checkDoiPrefix(){

}

upload();
checkFileType();
readXML();
validateXML();
getDoi();
insertIntoIUGONET();
transform("jalc");
transform("html");
?>
