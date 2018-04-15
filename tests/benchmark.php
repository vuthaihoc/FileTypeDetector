<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 4/15/18
 * Time: 23:14
 */

require __DIR__ . "/../vendor/autoload.php";

$link = "https://www.dropbox.com/s/e0sxjkhgqnl6idt/Document%20%281%29.docx?dl=1";
//$link = "https://www.dropbox.com/s/y691tiakfyh5k8l/themeforest-11989202-remark-responsive-bootstrap-4-admin-template.zip?dl=1";

$start = microtime(true);

$type1 = \Dok123\FileTypeDetector\Detector::detectByContent( $link, true);

$end1 = microtime(true);

$type2 = \Dok123\FileTypeDetector\Detector::detectByContent(__DIR__. "/word2010.docx");


$end2 = microtime(true);

echo "Type 1 " . ($end1 - $start) . " \n";
print_r( $type1);
echo "\nType 2 " . ($end2 - $end1) . " \n";
print_r( $type2);
