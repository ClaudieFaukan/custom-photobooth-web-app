<?php

namespace App\Service;

use UserConstante;

use App\Entity\User;
use App\Service\FileUploader;
use App\Form\ProfilPictureType;
use App\Entity\CustomProfilUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CustomProfilUserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomProfile extends AbstractController
{



    public function __construct(protected CustomProfilUserRepository $customRepository, protected FileUploader $file, EntityManagerInterface $em)
    {
    }
    /**
     * Recupere les donnes necessaire pour la sidebarProfile (form, photo ..)
     * 
     */

    public function getSideBar(User $user, Request $request)
    {
        $customProfilOriginal = clone ($this->customRepository->findOneBy(["userPropriety" => $this->getUser()]));
        $copyCustomProfil = self::getCustomProfil($user);

        $pictureProfilForm = $this->createForm(ProfilPictureType::class, $copyCustomProfil);
        $pictureProfilForm->handleRequest($request);

        if ($pictureProfilForm->isSubmitted() && $pictureProfilForm->isValid()) {

            $customProfil = $this->customProfile->savePictureProfil($copyCustomProfil, $pictureProfilForm);
            unlink(UserConstante::PICTURES_PROFIL_DIRECTORY . $customProfilOriginal->getPictureProfil());
            $customProfilOriginal = $copyCustomProfil;
            $this->em->persist($customProfil);
            $this->em->flush();
        }
        $customProfilOriginal->setPictureProfil(UserConstante::PICTURES_PROFIL_DIRECTORY . $customProfilOriginal->getPictureProfil());
        return ["customProfil" => $customProfilOriginal, "pictureProfilView" => $pictureProfilForm->createView()];
    }

    public function getCustomProfil(User $user): CustomProfilUser
    {
        $customProfil =  $this->customRepository->findOneBy(["userPropriety" => $user]);

        if ($customProfil->getPictureProfil() != null) {
            $customProfil = self::pictureProfil($customProfil);
        }

        return $customProfil;
    }


    public function pictureProfil(CustomprofilUser $profil): CustomProfilUser
    {
        $savePictureProfil = $profil->getPictureProfil();
        $profil->setPictureProfil("");

        return $profil;
    }


    public function savePictureProfil(CustomprofilUser $profil, FormInterface $form): CustomProfilUser
    {
        /** @var UploadedFile */
        $pictureProfil = $form->get('pictureProfil')->getData();

        if ($pictureProfil) {

            $fileName = $this->file->uploadProfilPicture($pictureProfil);
            $profil->setPictureProfil($fileName);
        }
        return $profil;
    }
}
