<?php
set_time_limit(0);
error_reporting(E_ALL);
ini_set("display_errors", true);

$start = 0;
$end = 100;

$output = getcwd() ."/video/$end.mp4";
$inputDir = getcwd() ."images/";
$inputStr = $inputDir ."%d.jpg";

#$command1="ffmpeg -f image2 -r 1/1 -i $inputStr -vf fps=60 $output";
$command1="ffmpeg -framerate 60 -f image2 -r 1/1 -i $inputStr -vf fps=60 $output";
//command for every 1 second image change in video
exec($command1);
