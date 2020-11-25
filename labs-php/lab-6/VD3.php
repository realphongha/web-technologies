<?php
//htmlentities( )
    $input= <<< End
    "Stop pulling my hair!" Jane's eyes flashed. <p>
    End;
    
    $double= htmlentities($input);
    echo $double . "<br />";
    
    $both= htmlentities($input, ENT_QUOTES);
    echo $both . "<br />";
    
    $neither= htmlentities($input, ENT_NOQUOTES);
    echo $neither . "<br />";

//htmlspecialchars()
    $input1 = <<< End
    "angle < 30" or "sturm & drang".
    End;
    $spec= htmlspecialchars($input1);
    echo $spec . "<br />";
 
//strip_tags( )
    $input2 = 'The <b>bold</b> tags will <i>stay</i><p>';
    $output = strip_tags($input2, '<b>');
    echo $output . "<br />";

//rawurlencode( )
    $name = "Programming PHP";
    $output1 = rawurlencode($name);
    echo "http://localhost/$output1" . "<br />";

//rawurldecode()
    $encoded = 'Programming%20PHP';
    echo rawurldecode($encoded) . "<br />";
 
//Query-string encoding and decoding
    $base_url = 'http://www.google.com/q=';
    $query = 'PHP sessions -cookies';
    $url = $base_url . urlencode($query);
    echo $url;