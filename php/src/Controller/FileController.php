<?php

namespace Controller;

use Model\Lamaran;

class FileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function accessFile($matches)
    {
        $filename = $matches[0];

        $storagePath = __DIR__ . '/../storage/';

        $requestUri = $_SERVER['REQUEST_URI'];
        if (strpos($requestUri, '/cv/') !== false) {
            $filePath = $storagePath . 'cv/' . $filename;
            $dbPath = '/storage/cv/'.$filename;
        } elseif (strpos($requestUri, '/video/') !== false) {
            $filePath = $storagePath . 'video/' . $filename;
            $dbPath = '/storage/video/'.$filename;
        }

        if (file_exists($filePath)) {
            if(!$this->lamaran->authorizeFile($dbPath,$this->cur_user['id'])){
                echo "<h3 class='page-heading'>You're not authorized to access this file</h3>";
            }

            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            switch ($extension) {
                case 'pdf':
                    header('Content-Type: application/pdf');
                    break;
                case 'docx':
                    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                    break;
                case 'mp4':
                    header('Content-Type: video/mp4');
                    break;
                default:
                    header('Content-Type: application/octet-stream');
                    break;
            }

            header('Content-Disposition: inline; filename="' . $filename . '"');
            readfile($filePath);
            exit;
        } else {
            echo "<h3 class='page-heading'>File doesn't exist</h3>";
            exit();
        }
    }
}
