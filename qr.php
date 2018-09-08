<?php
    header("content-type:text/html;charset=utf-8");
    
    set_time_limit(0); 
    error_reporting(0);
    $data = $_POST;
    require_once 'phpqrcode.php';
    
    //二维码地址
    $url = trim($data['url']);
    $urls = explode("\r\n", $url);
    
    //二维码名称
    $name = trim($data['name']);
    $names = explode("\r\n", $name);
    
    $errorCorrectionLevel = $data['level'];    //容错级别   
    $matrixPointSize = $data['size'];           //生成图片大小    
    
    //文件压缩
    $zipname = 'qrcode.zip';
    $zip = new ZipArchive();
    $zip->open($zipname, ZipArchive::OVERWRITE);
    //生成二维码图片 
    for($i=0;$i<count($urls);$i++){
        $filename = 'qrcode\\'.$names[$i].'.png';
        QRcode::png($urls[$i],$filename,$errorCorrectionLevel, $matrixPointSize, 2);
        $zip->addFile($filename);
    }
    $zip->close();
    // header("Cache-Control: public"); 
    // header("Content-Description: File Transfer"); 
    header('Content-disposition: attachment; filename='.$zipname); //文件名  
    header("Content-Type: application/zip"); //zip格式的  
    // header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件  
    // header('Content-Length: '. filesize($zipname)); //告诉浏览器，文件大小  
    readfile($zipname);