<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader extends AbstractController
{


    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    //@info Logo client
    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getParameter('logoClients_directory'), $fileName);
        } catch (FileException $e) {
            //TODO
        }

        return $fileName;
    }

    //@info pictures profil
    public function uploadPicture(UploadedFile $file, Componant $componant)
    {
        if ($componant == Componant::PicturesProfil) {

            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

            try {
                $file->move($this->getParameter('picturesProfile_directory'), $fileName);
            } catch (FileException $e) {
                //TODO
            }

            return $fileName;
        }
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();


        try {
            $file->move($this->getParameter('pictureProfilBackground_directory'), $fileName);
        } catch (FileException $e) {
            //TODO
        }

        return $fileName;
    }
}
