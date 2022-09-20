<?php

namespace App\Service;

use Exception;

use UserConstante;
use App\Entity\User;
use App\Service\FileUploader;
use App\Entity\CustomProfilUser;
use App\Form\navbar\ProfilPictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use App\Form\navbar\BackgroundProfilUserType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CustomProfilUserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

enum Componant
{
    case PicturesProfil;
    case BackgroundProfil;
}
class CustomProfile extends AbstractController
{

    public function __construct(protected CustomProfilUserRepository $customRepository, protected FileUploader $file, protected EntityManagerInterface $em)
    {
    }
    /**
     * Recupere les donnes necessaire pour la sidebarProfile (form, photo ..)
     * 
     */

    public function getSideBar(User $user, Request $request)
    {
        $sideBarComponents = [];
        //on ajoute le composant picture profil (photo+form)
        $backgroundProfilComponant = $this->getBacgroundProfilWithForm($user, $request);
        $pictureProfilComponant = $this->getPictureProfilWithForm($user, $request);
        $sideBarComponents =  array_merge($pictureProfilComponant, $backgroundProfilComponant);
        return $sideBarComponents;
    }

    public function getPictureProfilWithForm(User $user, Request $request)
    {
        $componant = Componant::PicturesProfil;
        //photo profil
        //recupere la photo acuel
        $customProfilOriginal = $this->customRepository->findOneBy(["userPropriety" => $this->getUser()]);

        //clone de l'objet et suppresion temporaire de photo picture pour le form (car seulement acpter un string et non fileUpload)
        $copyCustomProfil = $this->getCustomProfil($user, $componant);

        //creation du form
        $pictureProfilForm = $this->createForm(ProfilPictureType::class, $copyCustomProfil);
        $pictureProfilForm->handleRequest($request);

        if ($pictureProfilForm->isSubmitted() && $pictureProfilForm->isValid() && $pictureProfilForm->get('pictureProfil')->getData() != null) {

            //on effectue les check et enregistre sur le serveur et retourne le filename
            $customProfil = $this->saveImage($copyCustomProfil, $pictureProfilForm, $componant);

            //Si pas le premier changement de photo alros on supprime l'ancienne
            if ($customProfilOriginal->getPictureProfil() != null) {
                try {

                    unlink(UserConstante::PICTURES_PROFIL_DIRECTORY . $customProfilOriginal->getPictureProfil());
                } catch (Exception $e) {
                    //todo
                }
            }
            //On réassocie le clone sous le meme nom de base ' pour le fichier twig'
            $customProfilOriginal->setPictureProfil($customProfil->getPictureProfil());
            $this->em->persist($customProfilOriginal);
            $this->em->flush();
        }
        //retour d'objet sidebar comprenant la photo+le form de changement de photo
        return ["customProfil" => $customProfilOriginal, "pictureProfilView" => $pictureProfilForm->createView()];
    }

    public function getBacgroundProfilWithForm(User $user, Request $request)
    {
        $componant = Componant::BackgroundProfil;

        $customBackgroundOriginal = $this->customRepository->findOneBy(["userPropriety" => $this->getUser()]);

        $copyCustomProfil = $this->getCustomProfil($user, $componant);

        $pictureProfilForm = $this->createForm(ProfilPictureType::class, $copyCustomProfil);
        $pictureProfilForm->handleRequest($request);
        if ($pictureProfilForm->isSubmitted() && $pictureProfilForm->isValid() && $pictureProfilForm->get('pictureProfilBackground')->getData() != null) {

            $customProfil = $this->saveImage($copyCustomProfil, $pictureProfilForm, $componant);

            if ($customBackgroundOriginal->getPictureProfilBackground() != null) {
                try {

                    unlink(UserConstante::BACKGROUND_PROFIL_DIRECTORY . $customBackgroundOriginal->getPictureProfilBackground());
                } catch (Exception $e) {
                    //todo
                }
            }
            //On réassocie le clone sous le meme nom de base ' pour le fichier twig'
            $customBackgroundOriginal->setPictureProfilBackground($customProfil->getPictureProfilBackground());
            $this->em->persist($customBackgroundOriginal);
            $this->em->flush();
        }
        //retour d'objet sidebar comprenant la photo+le form de changement de photo
        return ["customProfil" => $customBackgroundOriginal, "backgroundProfilView" => $pictureProfilForm->createView()];
    }

    public function getCustomProfil(User $user, Componant $componant): CustomProfilUser
    {
        $customProfil =  clone ($this->customRepository->findOneBy(["userPropriety" => $user]));

        //recuperation de la photo

        //si deja une photo on l'efface temporairement pour le form sinon erreur : string attendus pas fileUpload
        if ($customProfil->getPictureProfil() != null) {
            $customProfil = $this->removeString($customProfil, $componant);
        }
        //Recuperation du background
        if ($customProfil->getPictureProfilBackground() != null) {
            $customProfil = $this->removeString($customProfil, $componant);
        }
        return $customProfil;
    }


    public function removeString(CustomprofilUser $profil, Componant $componant): CustomProfilUser
    {


        $profil->setPictureProfil("");



        $profil->setPictureProfilBackground('');

        return $profil;
    }


    public function saveImage(CustomprofilUser $profil, FormInterface $form, Componant $componant): CustomProfilUser
    {
        if ($componant == Componant::PicturesProfil) {

            /** @var UploadedFile */
            $pictureProfil = $form->get('pictureProfil')->getData();

            if ($pictureProfil) {

                $fileName = $this->file->uploadPicture($pictureProfil, $componant);
                $profil->setPictureProfil($fileName);
            }
            return $profil;
        }

        /** @var UploadedFile */
        $pictureBackground = $form->get('pictureProfilBackground')->getData();

        if ($pictureBackground) {

            $fileName = $this->file->uploadPicture($pictureBackground, $componant);
            $profil->setPictureProfilBackground($fileName);
        }
        return $profil;
    }
}
