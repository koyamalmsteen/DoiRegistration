<?php
$targetPath = '';
$targetFile = '';
$doi = '';
$dom = '';

$dsn = 'mysql:dbname=wdsj;host=localhost';
$user = 'insertOnlyUser';
$password = 'pass';
$dbn = '';

$saxon = "/var/www/html/saxon/lib/saxon9he.jar";

function upload(){
  global $targetPath, $targetFile;

  $ds = DIRECTORY_SEPARATOR;
  $storeFolder = 'uploads';

  if( !empty($_FILES) ){
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
  global $dsn;
  global $user;
  global $password;
  global $dbn;

  $dbn = new PDO($dsn, $user, $password);
  if (!dbn){
    errorHandling(__FUNCTION__, mysql_error());
  }

  $fp = fopen($targetFile,"r");
  $xml = fread($fp, filesize($targetFile));
  fclose($fp);

  $xml = addslashes($xml);

  $query = "INSERT INTO doc VALUES('".$doi."',1,1,1,'".$xml."')";

  $stmt = $dbn->query($query);
  if (!$stmt){
    errorHandling(__FUNCTION__, mysql_error());
  }
}

function transform($into){
  global $targetFile;
  global $doi;
  global $dsn;
  global $user;
  global $password;
  global $dbn;

  global $saxon;

  if( $into!="jalc" and $into!="html" ){
    errorHandling(__FUNCTION__, 'argument error');
  }

  $query = "";
  $doc_type = "";
  $output = "";

  if( $into=="jalc" ){
    $output = "/var/www/html/uploads/jalc.xml";
    $doc_type = 2;

    $cmd = escapeshellcmd("java -jar ".$saxon." -s:".$targetFile." -xsl:/var/www/html/xsl/iugonet2jalc.xsl -xsltversion:2.0 -o:".$output);
    $result = shell_exec($cmd);

    $fp = fopen("/tmp/test3","w+");
    fwrite($fp, $cmd);
    fclose($fp);

    /*
    if( $result==false ){
      errorHandling(__FUNCTION__, $cmd);
    }
    */
  }else if( $into=="html" ){
    $output = "/var/www/html/uploads/index.html";
    $doc_type = 3;

    $cmd = escapeshellcmd("java -jar ".$saxon." -s:".$targetFile." -o:".$output." -xsl:/var/www/html/xsl/iugonet2html.xsl -xsltversion:2.0");
    $result = shell_exec($cmd);
    /*
    if( $result==false ){
      errorHandling(__FUNCTION__, $into);
    }
    */
  }

  $fp = fopen($output, "w+");
  $xml = fread($fp, filesize($output));
  fclose($fp);

  $xml = addslashes($xml);

  $query = "INSERT INTO doc VALUES('".$doi."',1,1,".$doc_type.",'".$xml."')";


  $stmt = $dbn->query($query);
  if (!$stmt){
    errorHandling(__FUNCTION__, mysql_error());
  }
}

function errorHandling($errorFunctionName, $comment){
  // delete file;  

  $fp = fopen("/tmp/test2","w+");
  fwrite($fp, $errorFunctionName."() error!".$comment);
  fclose($fp);
  // print error message;

  die($errorFunctionName.$comment);
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
