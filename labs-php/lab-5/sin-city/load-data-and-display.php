<?php 
// set name of XML file 
$file = "sins.xml";
// load file 
$xml = simplexml_load_file($file) or die("Unable to load XML file!"); 
// access XML data 
foreach($xml as $sin){
    echo "Sin: " . $sin . "<br>";
}
?>