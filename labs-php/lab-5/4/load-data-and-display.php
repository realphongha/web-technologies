<?php 
// create XML string 
$file = "shape.xml";

// load file
$xml = simplexml_load_file($file) or die ("Unable to load XML string!"); 
// for each shape 
// calculate area 
foreach ($xml->shape as $shape) { 
    if ($shape['type'] == "circle") { 
        $area = pi() * $shape['radius'] * $shape['radius']; 
    } elseif ($shape['type'] == "rectangle") { 
        $area = $shape['length'] * $shape['width']; 
    } elseif ($shape['type'] == "square") { 
        $area = $shape['length'] * $shape['length'];
    } 
    echo $shape['type']." - area: ".$area."<p>"; 
} 
?>