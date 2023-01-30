<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/vorstand', name: 'vorstand')]
    public function vorstand(): Response
    {
        return $this->render('vorstand.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/schiessplan', name: 'schiessplan')]
    public function schiessplan(): Response
    {
        return $this->render('schiessplan.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/gruppenschiessen', name: 'gruppenschiessen')]
    public function gruppenschiessen(): Response
    {
        return $this->render('gruppenschiessen.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/feldschiessen', name: 'feldschiessen')]
    public function feldschiessen(): Response
    {
        return $this->render('feldschiessen.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/jungschuetzenkurs', name: 'jungschuetzenkurs')]
    public function jungschuetzenkurs(): Response
    {
        return $this->render('jungschuetzenkurs.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
