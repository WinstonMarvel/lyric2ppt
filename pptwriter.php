<?php

require_once 'extractorfunctions.php';
include 'mailfunctions.php';

require_once 'PhpOffice/PhpPresentation/Autoloader.php';
\PhpOffice\PhpPresentation\Autoloader::register();

require_once 'PhpOffice/Common/Autoloader.php';
\PhpOffice\Common\Autoloader::register();


use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;

use PhpOffice\PhpPresentation\Style\Alignment;

use PhpOffice\PhpPresentation\Slide\Background\Color;
use PhpOffice\PhpPresentation\Style\Color as StyleColor;
use \PhpOffice\PhpPresentation\Slide\Background\Image;
$pptobject = new PhpPresentation();

$slide=array(); $shape=array(); $textRun=array(); $para_array=array();


for($i=0; $i<=8;$i++){
  if(!empty($_POST["url$i"])) {

      $para_2d_array[]=determine_extractor(urlfixer($_POST["url$i"]));
  
  }


}


$para_array= array_reduce($para_2d_array, 'array_merge', array());

$slide0 = $pptobject->getActiveSlide();


$shape0 = $slide0->createRichTextShape()
      ->setHeight(300)
      ->setWidth(600)
      ->setOffsetX(170)
      ->setOffsetY(180);
$shape0->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );
$textRun0 = $shape0->createTextRun("You're using Lyric2PPT By Winston Marvel Jude ");
$textRun0->getFont()->setBold(true)
                   ->setSize(50)
                   ->setColor( new StyleColor( '000' ) );

$oBkgColor = new Color();
$oBkgColor->setColor(new StyleColor('FFFFCC'));
$slide0->setBackground($oBkgColor);





foreach($para_array as $para){



$slide = $pptobject->createSlide();

$shape = $slide->createRichTextShape()
      ->setHeight(300)
      ->setWidth(800)
      ->setOffsetX(80)
      ->setOffsetY(80);





$textRun = $shape->createTextRun($para);
$textRun->getFont()->setName('Arial');
$textRun->getFont()->setBold(false)
                   ->setSize(36)
                   ->setColor( new StyleColor( '#000' ) );
$shape->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_CENTER );


$slide->setBackground($oBkgColor);


}



$oWriterPPTX = IOFactory::createWriter($pptobject, 'PowerPoint2007');

 

 




    $filePath = sys_get_temp_dir() . "/" . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
    $oWriterPPTX->save($filePath);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-disposition: attachment; filename="Lyric2PPT-WinstonMarvel.com.pptx"');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');
    header('Pragma: public');    
    readfile($filePath);
    ignore_user_abort(TRUE);
    unlink($filePath);





/*
if(!empty($_POST["email"])){

  ppt_mailer();
}
*/





?>
