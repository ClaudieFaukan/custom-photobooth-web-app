<?php

namespace App\Controller;

use Exception;
use App\Entity\CustomProfilUser;
use App\Form\CustomProfilUserType;
use App\Form\ProfilPictureType;
use App\Repository\CustomProfilUserRepository;
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
    public function index(EntityManagerInterface $em, Request $request, FileUploader $file, CustomProfile $customProfile, CustomProfilUserRepository $customProfil): Response
    {
        $sideBarProfil = $customProfile->getSideBar($this->getUser(), $request);

        $optionsUser = $customProfil->findOneBy(["userPropriety" => $this->getUser()]);
        $logoOriginal = $optionsUser->getLogo();
        $optionsUser->setLogo("");
        $form = $this->createForm(CustomProfilUserType::class, $optionsUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile */
            $logo = $form->get('logo')->getData();

            if ($logo) {

                $fileName = $file->upload($logo);
                $optionsUser->setLogo($fileName);
            } else {
                $optionsUser->setLogo($logoOriginal);
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
