<?php


namespace App\Controller\Main;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends BaseController
{
    /**
     * @Route("/", name = "main")
     */
    public function index(){
        $forRender = parent::renderDefault();
        return $this->render('main/index.html.twig', $forRender);
    }
}