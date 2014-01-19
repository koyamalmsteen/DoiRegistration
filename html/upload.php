<?php
$targetPath = "";
$targetFile = "";
$doi = "";
$dom = "";

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
    errorHandling(__FUNCTION__);
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

  $fp = fopen("/tmp/test3","w+");

  if( !$dom->schemaValidate('http://www.iugonet.org/data/schema/iugonet-2_2_2_4.xsd') ){
    errorHandling(__FUNCTION__);
    fwrite($fp, "invalid");
  }else{

  }

  fclose($fp);
}

function getDoi(){
  global $targetFile;
  global $doi;
  global $dom;

  $fp = fopen("/tmp/test4","w+");
  fwrite($fp, "DOIOHOHOHOHO");
  fclose($fp);

  // if the metadata's resource type is Document/Catalog/DisplayData/NumericalData, retrieve DOI
  $doi = '10.1234/4567';
}

function insertIntoIUGONET(){
  global $targetFile;
  global $doi;

  $link = mysql_connect('localhost','insertOnlyUser','pass');
  if (!$link){
    die('[WDSJ] Connection Error'.mysql_error());
  }

  $db_selected = mysql_select_db('wdsj', $link);
  if (!$db_selected){
    die('[WDSJ] Database Selection Error'.mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $fp = fopen("/tmp/test5","w+");
  fwrite($fp, $xml);
  fclose($fp);

  $result = mysql_query("INSERT INTO iugonet VALUES('".$doi."',4,'C4','".$xml."')");
  if (!$result) {
    die('[WDSJ] Query failed.'.mysql_error());
  }
}

function transformIntoJaLC(){
  global $targetFile;
  global $doi;

  $link =   $link = mysql_connect('localhost','insertOnlyUser','pass');
  if (!$link){
    die('[WDSJ] Connection Error'.mysql_error());
  }
  
  $db_selected = mysql_select_db('wdsj', $link);
  if (!$db_selected){
    die('[WDSJ] Database Selection Error'.mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $fp = fopen("/tmp/test6","w+");
  fwrite($fp, $xml);
  fclose($fp);

  $result = mysql_query("INSERT INTO jalc VALUES('".$doi."',4,'C4','".$xml."')");
  if (!$result) {
    die('[WDSJ] Query failed.'.mysql_error());
  }

  //
  $jarFilePath = "saxon/lib/saxon9he.jar";

  //
  $cmd = escapeshellcmd("java -jar".$jarFilePath);

  //
  $result = shell_exec($cmd);
  if($result){
    echo $result;
  }else if($result==false){
    echo "NG";
  }
}

function transformIntoHTML(){
  global $targetFile;
  global $doi;

  $link =   $link = mysql_connect('localhost','insertOnlyUser','pass');
  if (!$link){
    die('[WDSJ] Connection Error'.mysql_error());
  }

  $db_selected = mysql_select_db('wdsj', $link);
  if (!$db_selected){
    die('[WDSJ] Database Selection Error'.mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $fp = fopen("/tmp/test7","w+");
  fwrite($fp, $xml);
  fclose($fp);

  $result = mysql_query("INSERT INTO html VALUES('".$doi."',4,'C4','".$xml."')");
  if (!$result) {
    die('[WDSJ] Query failed.'.mysql_error());
  }

  //
  $jarFilePath = "saxon/lib/saxon9he.jar";

  //
  $cmd = escapeshellcmd("java -jar".$jarFilePath);

  //
  $result = shell_exec($cmd);
  if($result){
    echo $result;
  }else if($result==false){
    echo "NG";
  }
}

function errorHandling($errorFunctionName){
  $fp = fopen("/tmp/test2","w+");
  // delete file;  

  //    fputs(STDERR, $errorFunctioname);
  fwrite($fp, $errorFunctionName."() error!");

  fclose($fp);
  // print error message;
}

function checkDoiPrefix(){

}

$up = upload();
if( $up == 0 ){
  echo "HOGE";
}
checkFileType();
readXML();
//validateXML();
getDoi();
insertIntoIUGONET();
transformIntoJaLC();
transformIntoHTML();
?>
