<?php

declare(strict_types=1);

namespace Infrastructure\Frontend;

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
            'persons' => [
                [
                    'name' => 'Hermann Pfister',
                    'image' => 'hermann.pfister.png',
                    'role' => 'Präsident',
                ],
                [
                    'name' => 'Rolad Müller',
                    'image' => 'roland.mueller.png',
                    'role' => 'Vize-Präsident und Kassier',
                ],
                [
                    'name' => 'Dominic Périsset',
                    'image' => 'dominic.perisset.png',
                    'role' => 'Aktuar',
                ],
                [
                    'name' => 'Remo Mächler',
                    'image' => 'remo.maechler.png',
                    'role' => 'Schiess-Sekretär',
                ],
                [
                    'name' => 'Andreas Bamert',
                    'image' => 'andreas.bamert.png',
                    'role' => 'Munitionsverwalter',
                ],
                [
                    'name' => 'Roger Käser',
                    'image' => 'roger.kaeser.png',
                    'role' => 'Hauptschützenmeister',
                ],
                [
                    'name' => 'Erhard Ziltener',
                    'image' => 'erhard.ziltener.png',
                    'role' => 'Schützenmeister',
                ],
                [
                    'name' => 'Beat Gräzer',
                    'image' => 'beat.graezer.png',
                    'role' => 'Jungschützenleiter',
                ],
            ],
        ]);
    }

    #[Route('/schiessplan', name: 'schiessplan')]
    public function schiessplan(): Response
    {
        return $this->render('schiessplan.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/op', name: 'op')]
    public function schiessenOp(): Response
    {
        return $this->render('op.html.twig', [
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
