<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/vorstand", name="vorstand")
     */
    public function vorstand()
    {
        return $this->render('vorstand.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/schiessplan", name="schiessplan")
     */
    public function schiessplan()
    {
        return $this->render('schiessplan.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/gruppenschiessen", name="gruppenschiessen")
     */
    public function gruppenschiessen()
    {
        return $this->render('gruppenschiessen.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/feldschiessen", name="feldschiessen")
     */
    public function feldschiessen()
    {
        return $this->render('feldschiessen.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/jungschuetzenkurs", name="jungschuetzenkurs")
     */
    public function jungschuetzenkurs()
    {
        return $this->render('jungschuetzenkurs.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
