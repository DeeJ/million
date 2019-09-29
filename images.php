<?
$timeStart = microtime(true);
$debug = false;
if (!empty($_GET['debug'])) {
	$debug = true;
}

require_once "facts.php";

set_time_limit(0);
error_reporting(E_ALL);
ini_set('display_errors', true);

$fontSize = 130;
$factFontSize = 20;

#$imWidth = 1920;
#$imHeight = 1080;
$imWidth = 1280;
$imHeight = 720;
$imQuality = 70;

$created = 0;
$start 	= 0;
$stop 	= 1000000;
$current = $start;

$fps = 60;
$factSecs = 180;
$factFrames = $fps * $factSecs;

$fileSize = 0;

$fontFile = getcwd(). "/fonts/consola.ttf";
$factFrame = 0;
$currentFact = 0;
while ($current < $stop) {
	
	$current++;
	$created++;
	$factFrame++;

	$im = imagecreate($imWidth, $imHeight);
	$bg = imagecolorallocate($im, 255, 255, 255);
	$textColor = imagecolorallocate($im, 0, 0, 0);


	$textString = number_format($current);

	$typeSpace = imagettfbbox($fontSize, 0, $fontFile, $textString);

	// Determine image width and height, 10 pixels are added for 5 pixels padding:
	$textWidth = round($typeSpace[2] - $typeSpace[0]);
	//$textHeight = round($typeSpace[3] - $typeSpace[5]);
	$textHeight = $fontSize;

	$fontX = ($imWidth/2) - ($textWidth/2);
	$fontY = ($imHeight/2) + ($textHeight/2);

	// Write the string at the top left
	//imagestring($im, 4, $fontX, $fontY, $textString, $textcolor);
	imagettftext($im, $fontSize, 0, $fontX, $fontY, $textColor, $fontFile, $textString);

	//
	// Display fact
	//
	$factTextArray = array_reverse(explode("\r\n", $facts[$currentFact]));
	if ($current >= $stop) {
		$factTextArray = array(
			"Well that took a while but we did it!",
		);
	}
	$factY = 0;
	foreach ($factTextArray as $factText) {

		$factText = trim($factText);

		//$factText = $facts[$currentFact];
		$factTypeSpace = imagettfbbox($factFontSize, 0, $fontFile, $factText);
		$factTextWidth = round($factTypeSpace[2] - $factTypeSpace[0]);
		$factTextHeight = round($factTypeSpace[3] - $factTypeSpace[5]);

		$factY += $factTextHeight;
		$factFontX = ($imWidth/2) - ($factTextWidth/2);
		$factFontY = ($imHeight-50) - $factY;

		imagettftext($im, $factFontSize, 0, $factFontX, $factFontY, $textColor, $fontFile, $factText);
	}
	//
	// End fact
	//


	$outputFile = "$current.jpg";
	$output = "images/". $outputFile;

	// Output the image
	#header('Content-type: image/jpeg');
	imagejpeg($im, $output, $imQuality);
	imagedestroy($im);

	$fileSize += filesize($output);

	if ($factFrame >= $factFrames) {
		$factFrame = 0;
		$currentFact++;
		if (empty($facts[$currentFact])) {
			$currentFact = 0;
		}
	}

}

echo "Created: $created<br />";

$timeEnd = microtime(true);
$executionTime = ($timeEnd - $timeStart);
echo '<b>Total Execution Time:</b> '.secondsToTime($executionTime).' secs<br />';
echo "Size: ". FileSizeConvert($fileSize) ."<br />";

echo "<br /><hr /><br />";
$timePerImage = $executionTime/$created;
echo "Time per image: $timePerImage secs<br />";
$sizePerImage = $fileSize / $created;
echo "Size per image: ". FileSizeConvert($sizePerImage) ."<br />";

echo "<br /><hr /><br />";
$timePerMillion = $timePerImage * 1000000;
echo "Time per million: ". secondsToTime($timePerMillion) ."<br />";
$sizePerMillion = $sizePerImage * 1000000;
echo "Size per million: ". FileSizeConvert($sizePerMillion) ."<br />";

echo "<br /><hr /><br />";
$timePerBillion = $timePerImage * 1000000000;
echo "Time for 1 billion: ". secondsToTime($timePerBillion) ."<br />";
$sizePerBillion = $sizePerImage * 1000000000;
echo "Size for 1 billion: ". FileSizeConvert($sizePerBillion) ."<br />";



die();






/**
 * Functions
 */
function secondsToTime($seconds) {

	$seconds = round($seconds);

    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}
function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "." , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}
