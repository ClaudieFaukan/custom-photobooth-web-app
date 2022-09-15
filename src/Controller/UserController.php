<?php

namespace App\Controller;

use App\Entity\UserOfClient;
use App\Form\ClientOfUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile/user/add', name: 'app_add_user')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $userOfClient = new UserOfClient();
        $clientForm = $this->createForm(ClientOfUserType::class, $userOfClient);
        $clientForm->handleRequest($request);

        if ($clientForm->isSubmitted() && $clientForm->isValid()) {

            $userOfClient->setUserPropriety($this->getUser());
            $em->persist($userOfClient);
            $em->flush();

            $this->addFlash("success", "Client ajouter");
        }

        return $this->render('user/index.html.twig', [
            'clientForm' => $clientForm->createView(),
        ]);
    }
}
