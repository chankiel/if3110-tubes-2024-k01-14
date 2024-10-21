<?php

namespace Helper;

class FileManager
{
    public static function uploadFile($type)
    {
        $upload_dir = dirname(__DIR__) . '/storage/'. $type;

        if(!isset($_FILES[$type])){
            return null;
        }

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);  // Create the directory with permissions and recursive flag
        }

        $file = $_FILES[$type]['tmp_name'];
        $filename = basename($_FILES[$type]['name']);
        $target = $upload_dir . '/' . $filename;

        if (!empty($file)) {
            if (move_uploaded_file($file, $target)) {
                return "/storage/".$type.'/'.$filename;
            } else {
                return null;
            }
        }else{
            return null;
        }
    }
}
