<?php

namespace App\Controller;

use App\Entity\UserOfClient;
use App\Form\ClientOfUserType;
use App\Service\CustomProfile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile/user/add', name: 'app_add_user')]
    public function add(Request $request, EntityManagerInterface $em, CustomProfile $customProfile): Response
    {
        /** @var User */
        $user = $this->getUser();
        $sideBar = $customProfile->getSideBar($this->getUser(), $request);
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
            'sideBar' => $sideBar,
            'clientForm' => $clientForm->createView(),
        ]);
    }
}
