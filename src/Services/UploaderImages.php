<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderImages
{
    private $directory;
    private $images_directory;

    public function __construct($images_directory)
    {
        $this->directory = $images_directory;
    }

    public function upload(UploadedFile $image, $nom = null)
    {

        if (!$nom) {
            $nom = uniqid();
        }

        $nouveauNom = $nom . "." . $image->guessExtension();

        $image->move($this->directory, $nouveauNom);

        return $nouveauNom;
    }
}
