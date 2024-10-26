<?php

namespace Helper;

class FileManager
{
    public static function getAndUploadFile($dir, $type, $new_filename)
    {
        $upload_dir = dirname(__DIR__) . $dir . $type;

        if (!isset($_FILES[$type])) {
            return null;
        }

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file = $_FILES[$type]['tmp_name'];
        $file_extension = pathinfo($_FILES[$type]['name'], PATHINFO_EXTENSION);
        $target = $upload_dir . '/' . $new_filename . '.' . $file_extension;

        if (!empty($file)) {
            if (move_uploaded_file($file, $target)) {
                return $dir . $type . '/' . $new_filename . '.' . $file_extension;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function uploadFile($dir, $type, $fileTmpName, $fileName)
    {
        $upload_dir = dirname(__DIR__) . $dir . $type;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $fileBaseName = pathinfo($fileName, PATHINFO_FILENAME);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        $target = $upload_dir . '/' . basename($fileName);
        $counter = 1;

        while (file_exists($target)) {
            $newFileName = $fileBaseName . '-' . $counter . '.' . $fileExtension;
            $target = $upload_dir . '/' . $newFileName;
            $counter++;
        }

        if (!empty($fileTmpName)) {
            if (move_uploaded_file($fileTmpName, $target)) {
                return $dir . $type . '/' . basename($fileName);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function deleteFile($file_path)
    {
        $file_path = ltrim($file_path, '/');
        $absPath = dirname(__DIR__) . '/' . $file_path;
        if (file_exists($absPath)) {
            if (unlink($absPath)) {
                return true;
            }
        }
        return false;
    }
}
