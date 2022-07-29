<?php
	
    // Include the library in your project
    require ('vendor/autoload.php');
	
    // Instantiate the library class
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $dir = "qr-code/";
    
    // Directory to store barcode
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    // data string to encode
    $source = "656656";
	
    // ser properties
    $qrcodeObj = $barcode->getBarcodeObj('QRCODE,H', $source, - 16, - 16, 'black', array(
        - 2,
        - 2,
        - 2,
        - 2
    ))->setBackgroundColor('#f5f5f5');
    
    // generate qrcode
    $imageData = $qrcodeObj->getPngData();
    $timestamp = time();
    
    //store in the directory
    file_put_contents($dir . $timestamp . '.png', $imageData);
	
     //Output image to the browser
      echo '<img src="'.$dir . $timestamp.'.png" width="200px" height="200px">';
?>