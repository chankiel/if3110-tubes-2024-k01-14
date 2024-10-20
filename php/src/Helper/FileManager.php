<?php

namespace Helper;

class FileManager
{
    public static function uploadFile($type)
    {
        $upload_dir = dirname(__DIR__) . '/storage/'. $type;

        $file = $_FILES['cv']['tmp_name'];
        $filename = basename($_FILES['cv']['name']);
        $target = $upload_dir . '/' . $filename;

        if (!empty($file)) {
            if (move_uploaded_file($file, $target)) {
                return "/storage/".$type.'/'.$filename;
            } else {
                return null;
            }
        }
    }
}
