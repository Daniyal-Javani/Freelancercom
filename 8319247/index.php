<?php
/*=============================================================================
#  Author:          Daniyal Javani
#  Email:           Daniyal.javani@gmail.com
#  Project URL 		https://www.freelancer.com/projects/php/Copy-some-data-from-given-8319247/
#  Description:     Convert webpage to csv
#  Web page URL     http://www.utas.edu.au/international/contact-us/representatives?sq_content_src=%2BdXJsPWh0dHAlM0ElMkYlMkZ3d3cuaW50ZXJuYXRpb25hbC51dGFzLmVkdS5hdSUyRnJlcHMlMkZyZXBsaXN0LnBocCUzRmlkJTNEMTMmYWxsPTE%3D
#  Description:		src.html saved with firefox text file.
#  LastChange:      2015-08-23
=============================================================================*/ 
$myFile = "src.html";
$lines = file($myFile);//file in to an array
$j = 0;
$fp = fopen('file.csv', 'w');
echo count($lines);
while ($j < count($lines)-1) {
    $result = array();
    
    for(;$lines[$j][0]!='*';$j++);
    $i = 1;

    $result[0] = 'University of Tasmania';
    
    //Agency Name
    echo trim(substr($lines[$j], 1, strpos($lines[$j], '*', 1)-1))."\n";
    $result[2] = trim(substr($lines[$j], 1, strpos($lines[$j], '*', 1)-1));
    
    //Office Name
    echo trim(substr($lines[$j], strpos($lines[$j], '(')+1, strpos($lines[$j], ')')- strpos($lines[$j], '(')-1))."\n";
    $result[3] = trim(substr($lines[$j], strpos($lines[$j], '(')+1, strpos($lines[$j], ')')- strpos($lines[$j], '(')-1));
    
    for($k = 0,$j += 2; ; ++$j,++$k){
        if($k == 0){
            echo trim($lines[$j])."\n"; //Address 1
            $result[4] = trim($lines[$j]);
        }
        else if($k == 1){
            echo trim($lines[$j])."\n"; //Address 2
            $result[5] = trim($lines[$j]);
        }
        else if($k == 2 && strpos($lines[$j], ',')===false){
            echo trim($lines[$j])."\n"; //Suburn
            $result [6] = trim($lines[$j]);
        }
        if($k > 1 && strpos($lines[$j], ',')!==false ){ 
            //It have state & postcode
            $state_postcode = explode(',', $lines[$j]);
            echo trim($state_postcode[0])."\n"; //state
            $result[7] = trim($state_postcode[0]);
            echo trim($state_postcode[1])."\n"; // postcode
            $result[8] = trim($state_postcode[1]);

            ++$j;
            echo trim($lines[$j])."\n"; //Country
            $result[1] = trim($lines[$j]);
            break;
        }
    }

    //phone
    ++$j;
    echo trim(substr($lines[$j], strpos($lines[$j], ':')+1))."\n"; // phone
    $result[9] = trim(substr($lines[$j], strpos($lines[$j], ':')+1));
    
    //fax
    ++$j;
    echo trim(substr($lines[$j], strpos($lines[$j], ':')+1))."\n"; // fax
    $result[10] = trim(substr($lines[$j], strpos($lines[$j], ':')+1));
    
    //email
    ++$j;
    $email_array = explode(' ', $lines[$j]);
    if(trim($email_array[1]) != '<mailto:>'){
        echo trim($email_array[1])."\n"; //email
        $result[11] = trim($email_array[1]);
    }
    
    
    //web
    ++$j;
    $web_array = explode(' ', $lines[$j]);
    echo trim($web_array[1])."\n";// web
    $result[12] = trim($web_array[1]);

    //Official contact
    ++$j;
    echo trim(substr($lines[$j], strpos($lines[$j], ':')+1))."\n";

    //Legal entity:
    ++$j;
    echo trim(substr($lines[$j], strpos($lines[$j], ':')+1))."\n";

    //Principal agent
    ++$j;
    echo trim(substr($lines[$j], strpos($lines[$j], ':')+1))."\n";
    $result[13] = trim(substr($lines[$j], strpos($lines[$j], ':')+1));
    
    echo "\n\n";
    
    fputcsv($fp, $result);
    
}
fclose($fp);




// @$connection = phpQuery::newDocumentFileHTML('http://www.niazpardaz.com/-@'.$url[0], $charset = 'utf-8');
					// $address = pq('#email img', $connection)->attr('email');					//Special for this website
