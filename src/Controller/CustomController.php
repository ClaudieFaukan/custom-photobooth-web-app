<?php

namespace App\Controller;

use Exception;
use App\Entity\CustomProfilUser;
use App\Form\CustomProfilUserType;
use App\Form\ProfilPictureType;
use App\Service\CustomProfile;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomController extends AbstractController
{
    #[Route('/profile/custom', name: 'app_custom')]
    public function index(EntityManagerInterface $em, Request $request, FileUploader $file, CustomProfile $customProfile): Response
    {
        $sideBarProfil = $customProfile->getSideBar($this->getUser(), $request);

        $optionsUser = new CustomProfilUser;
        $optionsUser->setUserPropriety($this->getUser());
        $form = $this->createForm(CustomProfilUserType::class, $optionsUser);
        $form->handleRequest($request);
        $pictureProfilForm = $this->createForm(ProfilPictureType::class, $optionsUser);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile */
            $logo = $form->get('logo')->getData();

            if ($logo) {

                $fileName = $file->upload($logo);
                $optionsUser->setLogo($fileName);
            }

            $em->persist($optionsUser);
            $em->flush();

            $this->addFlash("success", "Profil de personnalisation mis a jour");
        }

        return $this->render('custom/index.html.twig', [
            'form' => $form->createView(),
            'sideBar' => $sideBarProfil,
        ]);
    }
}
