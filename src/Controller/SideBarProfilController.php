<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SideBarProfilController extends AbstractController
{
    #[Route('/side/bar/profil/update', name: 'app_side_bar_profil')]
    public function index(): Response
    {



        return $this->render('side_bar_profil/index.html.twig', [
            'controller_name' => 'SideBarProfilController',
        ]);
    }
}
