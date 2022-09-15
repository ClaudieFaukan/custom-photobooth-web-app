<?php

namespace App\Controller;

use App\Service\FileUploader;
use App\Service\CustomProfile;
use App\Form\ProfilPictureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CustomProfilUserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use UserConstante;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(CustomProfile $customProfile, Request $request): Response
    {

        $sideBarProfil = $customProfile->getSideBar($this->getUser(), $request);

        return $this->render('profile/index.html.twig', [
            'sideBar' => $sideBarProfil,
        ]);
    }

    #[Route('/orders', name: 'orders')]
    public function orders(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Commandes de l\'utilisateur',
        ]);
    }
}
