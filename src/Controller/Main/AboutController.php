<?php


namespace App\Controller\Main;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends MainController
{
    /**
     * @Route ("/about", name = "about")
     */
    public function index(){
        $forRender = parent::renderDefault();
        return $this->render('main/about.html.twig', $forRender);
    }
}