<?php

// Root path to recursively scan
// Always end this with a trailing /
$ROOT = '/path_to_drive_or_folder/';


/* ---------------------------------------------------------------------------------------------------- */
/* ---------------------------------------DO NOT MODIFY BELOW------------------------------------------ */
/* ---------------------------------------------------------------------------------------------------- */


function detectSpecialCharacters($string) {

	if(preg_match('/[^\x20-\x7f]/', $string))
		return true;
	else
		return false;

} // detectSpecialCharacters()


function findSpecialDirectories($dir) {

	$scan = array_diff(scandir($dir), array('..', '.', '@eaDir'));

	foreach($scan as $key => $value) {
		if(is_dir($dir . DIRECTORY_SEPARATOR . $value)) { 
			if(detectSpecialCharacters($value)) {
				$newValue = cleanSpecialNames($dir . DIRECTORY_SEPARATOR . $value);
				echo $dir . DIRECTORY_SEPARATOR . $value . "\n";
				echo $newValue . "\n\n";
				rename($dir . DIRECTORY_SEPARATOR . $value, $newValue);
				return true;
			} else {
				$subresult = findSpecialFiles($dir . DIRECTORY_SEPARATOR . $value);				
			}
		} 
	}  // foreach

	return false;

} // findSpecialDirectories()


function findSpecialFiles($dir) { 
   
	$result = array(); 
	$scan = array_diff(scandir($dir), array('..', '.', '@eaDir'));

	foreach($scan as $key => $value) {
		if(is_dir($dir . DIRECTORY_SEPARATOR . $value)) { 
			$subresult = findSpecialFiles($dir . DIRECTORY_SEPARATOR . $value);
			if(sizeof($subresult) > 0)
				$result[$value] = $subresult; 
		} else {
			if(detectSpecialCharacters($value) && !empty($value)) {
				$result[] = $value;
			}
		} 
	}  // foreach

	return $result; 

} // findSpecialFiles()


// Original function credit to Silas Palmer https://stackoverflow.com/users/2067667/silas-palmer
// https://stackoverflow.com/questions/8781911/remove-non-ascii-characters-from-string
// Modified below
function cleanSpecialNames($value) {

    $text = $value;

    // Single letters
    $text = preg_replace("/[∂άαáàâãªäáãà]/u",      "a", $text);
    $text = preg_replace("/[∆лДΛдАÁÀÂÃÄÁÃÀ]/u",     "A", $text);
    $text = preg_replace("/[ЂЪЬБъь]/u",           "b", $text);
    $text = preg_replace("/[βвВ]/u",            "B", $text);
    $text = preg_replace("/[çς©сç]/u",            "c", $text);
    $text = preg_replace("/[ÇСÇ]/u",              "C", $text);        
    $text = preg_replace("/[δ]/u",             "d", $text);
    $text = preg_replace("/[éèêëέëèεе℮ёєэЭé]/u", "e", $text);
    $text = preg_replace("/[ÉÈÊË€ξЄ€Е∑É]/u",     "E", $text);
    $text = preg_replace("/[₣]/u",               "F", $text);
    $text = preg_replace("/[НнЊњ]/u",           "H", $text);
    $text = preg_replace("/[ђћЋ]/u",            "h", $text);
    $text = preg_replace("/[ÍÌÎÏ]/u",           "I", $text);
    $text = preg_replace("/[íìîïιίϊі]/u",       "i", $text);
    $text = preg_replace("/[Јј]/u",             "j", $text);
    $text = preg_replace("/[ΚЌК]/u",            'K', $text);
    $text = preg_replace("/[ќк]/u",             'k', $text);
    $text = preg_replace("/[ℓ∟]/u",             'l', $text);
    $text = preg_replace("/[Мм]/u",             "M", $text);
    $text = preg_replace("/[ñηήηπⁿ]/u",            "n", $text);
    $text = preg_replace("/[Ñ∏пПИЙийΝЛ]/u",       "N", $text);
    $text = preg_replace("/[óòôõºöοФσόоó]/u", "o", $text);
    $text = preg_replace("/[ÓÒÔÕÖθΩθОΩÓ]/u",     "O", $text);
    $text = preg_replace("/[ρφрРф]/u",          "p", $text);
    $text = preg_replace("/[®яЯ]/u",              "R", $text); 
    $text = preg_replace("/[ГЃгѓ]/u",              "r", $text); 
    $text = preg_replace("/[Ѕ]/u",              "S", $text);
    $text = preg_replace("/[ѕ]/u",              "s", $text);
    $text = preg_replace("/[Тт]/u",              "T", $text);
    $text = preg_replace("/[τ†‡]/u",              "t", $text);
    $text = preg_replace("/[úùûüџμΰµυϋύ]/u",     "u", $text);
    $text = preg_replace("/[√]/u",               "v", $text);
    $text = preg_replace("/[ÚÙÛÜЏЦц]/u",         "U", $text);
    $text = preg_replace("/[Ψψωώẅẃẁщш]/u",      "w", $text);
    $text = preg_replace("/[ẀẄẂШЩ]/u",          "W", $text);
    $text = preg_replace("/[ΧχЖХж]/u",          "x", $text);
    $text = preg_replace("/[ỲΫ¥]/u",           "Y", $text);
    $text = preg_replace("/[ỳγўЎУуч]/u",       "y", $text);
    $text = preg_replace("/[ζ]/u",              "Z", $text);

    // Punctuation
    $text = preg_replace("/[‚‚]/u", ",", $text);        
    $text = preg_replace("/[`‛′’‘]/u", "'", $text);
    $text = preg_replace("/[″“”„]/u", '"', $text);
    $text = preg_replace("/[″»]/u", '>>', $text);
    $text = preg_replace("/[″«]/u", '<<', $text);
    $text = preg_replace("/[—–―−–‾⌐─↔→←]/u", '-', $text);
    $text = preg_replace("/[  ]/u", ' ', $text);

    $text = str_replace("…", "...", $text);
    $text = str_replace("≠", "!=", $text);
    $text = str_replace("≤", "<=", $text);
    $text = str_replace("≥", ">=", $text);
    $text = preg_replace("/[‗≈≡]/u", "=", $text);


    // Exciting combinations    
    $text = str_replace("ыЫ", "bl", $text);
    $text = str_replace("℅", "c/o", $text);
    $text = str_replace("₧", "Pts", $text);
    $text = str_replace("™", "tm", $text);
    $text = str_replace("№", "No", $text);        
    $text = str_replace("Ч", "4", $text);                
    $text = str_replace("‰", "%", $text);
    $text = preg_replace("/[∙•]/u", "*", $text);
    $text = str_replace("‹", "<", $text);
    $text = str_replace("›", ">", $text);
    $text = str_replace("‼", "!!", $text);
    $text = str_replace("⁄", "/", $text);
    $text = str_replace("∕", "/", $text);
    $text = str_replace("⅞", "7/8", $text);
    $text = str_replace("⅝", "5/8", $text);
    $text = str_replace("⅜", "3/8", $text);
    $text = str_replace("⅛", "1/8", $text);        
    $text = preg_replace("/[‰]/u", "%", $text);
    $text = preg_replace("/[Љљ]/u", "Ab", $text);
    $text = preg_replace("/[Юю]/u", "IO", $text);
    $text = preg_replace("/[ﬁﬂ]/u", "fi", $text);
    $text = preg_replace("/[зЗ]/u", "3", $text); 
    $text = str_replace("£", "(pounds)", $text);
    $text = str_replace("₤", "(lira)", $text);
    $text = preg_replace("/[‰]/u", "%", $text);
    $text = preg_replace("/[↨↕↓↑│]/u", "|", $text);
    $text = preg_replace("/[∞∩∫⌂⌠⌡]/u", "", $text);

    // remove non ascii characters
    $text =  preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $text);      

    return $text;

} // cleanSpecialNames()


function cleanSpecialFiles($specialFiles, $path, $depth=0) {

	foreach($specialFiles as $key => $value) {

		if(!is_numeric($key))
			$result .= str_repeat(' ', ($depth*2)) . "Traversing $ROOT . $key\n";

		if(is_array($value)) {
			$result .= cleanSpecialFiles($value, $path . $key . '/', $depth+1);
		} else {
			$newValue = cleanSpecialNames($value);
			rename($path . $value, $path . $newValue);
			$result .= str_repeat(' ', ($depth*2)) . "- Renaming:\n" . str_repeat(' ', ($depth*2)) . "  $value\n" . str_repeat(' ', ($depth*2)) . "  $newValue\n\n";
		}

		if(!is_numeric($key))
			$result .= "\n";

	}

	return $result;

} // cleanSpecialFiles()



// Step 1: Go through and address all special characters in filenames
echo "*************************** Cleaning Files ***************************\n\n";
$specialFiles = findSpecialFiles($ROOT);
$results = cleanSpecialFiles($specialFiles, $ROOT);
echo $results . "\n\n";


// Step 2: Go through and address all special characters in directory names
echo "*************************** Cleaning Directories ***************************\n\n";
$found = 0;
while(findSpecialDirectories($ROOT)) {
	$found++;
}
echo "Cleaned $found directories.\n\n";


?>