<?php

namespace Controller;

use Model\Lamaran;

class FileController extends Controller
{
    private Lamaran $lamaran;

    public function __construct()
    {
        parent::__construct();
        $this->lamaran = new Lamaran();
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
                header("Location: /not-found");
                exit();
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
            header("Location: /not-found");
            exit();
        }
    }
}
