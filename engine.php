<?php

$words=array();

for ($i=0; $i<rand(2,5); $i++){
	
		$words[$i]=pickword("words.txt", rand(1,98500));
		
	}

echo json_encode($words);
	
// buildquery($words);



function buildquery($words){
	$str="";
	for ($i=0; $i<count($words); $i++)
		$str .= $words[$i]."+";
	$url = "http://www.google.com/search?q=".$str."&btnI=I%27m+Feeling+Lucky";
	// echo $url;
	//header('Location: '.$url);


}


function pickword($file,$line){
    $occurence = 0;
    $contents = '';
    $startPos = -1;
    if (!file_exists($file)) return '';
    $fp = @fopen($file, "rb");
    if (!$fp) return '';
    while (!@feof($fp)) {
        $str = @fread($fp, 1024);
        $number_of_occurences = strpos_count($str,"\n");
        if ($number_of_occurences == 0) {if ($start_pos != -1) {$contents .= $str;}}
        else {
            $lastPos = 0;
            for ($i = 0; $i < $number_of_occurences; $i++){
                $pos = strpos($str,"\n", $lastPos);
                $occurence++;
                if ($occurence == $line) {
                    $startPos = $pos;
                    if ($i == $number_of_occurences - 1) {$contents = substr($str, $startPos + 1);}
                } elseif ($occurence == $line + 1) {
                    if ($i == 0) {$contents .= substr($str, 0, $pos);} else {$contents = substr($str, $startPos, $pos - $startPos);}
                    $occurence = 0;
                    break;
                }
                $lastPos = $pos + 1;
            }
        }
    }
    @fclose($fp);
    return trim($contents);
} 

function strpos_count($haystack, $needle, $i = 0) {
    while (strpos($haystack,$needle) !== false) {$haystack = substr($haystack, (strpos($haystack,$needle) + 1)); $i++;}
    return $i;
} 

?>

