<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Repository\DemandeCongeRepository;
use App\Repository\PointageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{


    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
        ]);
    }
}
