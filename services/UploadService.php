<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploadService
 *
 * @author Yanik
 */
class UploadService {
    private $_uploadPath;
    private $_uploadedFile;
    private $_uploadedFiles = [];
    
    public function __construct($uploadDirectory) {
        $this->_uploadPath = $uploadDirectory;
    }
    
    public function uploadSingleFile($file){
        $status = "error";
        $result = "";
        $randomFilename = $this->_generateRandomFileName($file["name"]);
        if (move_uploaded_file($file["tmp_name"], $this->_uploadPath.$randomFilename)) {
            $status = "ok";
            $result = $randomFilename;
            $this->_uploadedFile = $randomFilename;
        } 
        
        return [
            "uploadedFile" => $randomFilename,
            "status" => $status
        ];
    }
    
    public function uploadMultipleFiles($files = []){
        $notUploadedCount = 0;
        $uploadedCount = 0;
        $filesNotUploaded = [];
        
        foreach($files["tmp_name"] as $path){
            $count = $filesNotUploaded+$notUploadedCount;
            $randomFilename = $this->_generateRandomFileName($files["name"][$count]);
            if (!move_uploaded_file($path, $this->_uploadPath.$randomFilename)) {
                $filesNotUploaded[$notUploadedCount]= $randomFilename;
                $notUploadedCount++;
            }else{ 
                $this->_uploadedFiles[$uploadedCount]=$randomFilename;
                $uploadedCount++;
            }
        }

        return [
            "uploaded" => $this->_uploadedFiles,
            "failed" => $filesNotUploaded
        ];
    }
    
    
    public function removeFiles(){
        if(count($this->_uploadedFiles) > 0){
            foreach($this->_uploadedFiles as $path){
                if(@unlink($this->_uploadPath.$path)){
                    continue;
                }
            }
        }else{
            @unlink($this->_uploadPath.$this->_uploadedFile);
        }
    }
    
    public function removeFile($file){
        @unlink($this->_uploadPath.$file);
    }
    
    private function _generateRandomFileName($filename){
        $temp = explode(".", $filename);
        $randomFilename = round(microtime(true)) . '.' . end($temp);
        return $randomFilename;
    }
}
