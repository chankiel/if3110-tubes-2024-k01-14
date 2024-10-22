<?php

namespace Helper;

class FileManager
{
    public static function getAndUploadFile($dir,$type)
    {
        $upload_dir = dirname(__DIR__) . $dir . $type;

        if(!isset($_FILES[$type])){
            return null;
        }

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); 
        }

        $file = $_FILES[$type]['tmp_name'];
        $filename = basename($_FILES[$type]['name']);
        $target = $upload_dir . '/' . $filename;

        if (!empty($file)) {
            if (move_uploaded_file($file, $target)) {
                return $dir.$type.'/'.$filename;
            } else {
                return null;
            }
        }else{
            return null;
        }
    }

    public static function uploadFile($dir,$type, $fileTmpName, $fileName)
    {
        $upload_dir = dirname(__DIR__) . $dir . $type;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);  
        }

        $target = $upload_dir . '/' . basename($fileName);

        if (!empty($fileTmpName)) {
            if (move_uploaded_file($fileTmpName, $target)) {
                return $dir.$type.'/'.basename($fileName);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function deleteFile($file_path){
        $file_path = ltrim($file_path,'/');
        $absPath = dirname(__DIR__) . '/' . $file_path;
        if(file_exists($absPath)){
            if(unlink($absPath)){
                return true;
            }
        }
        return false;
    }
}
