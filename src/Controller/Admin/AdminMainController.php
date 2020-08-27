<?php


namespace App\Controller\Admin;
use Symfony\Component\Routing\Annotation\Route;

class AdminMainController extends AdminBaseController
{
    /**
     * @Route("/admin", name = "admin_main")
     */
    public function index(){
        $forRender = parent::renderDefault();
        return $this->render('admin/index.html.twig', $forRender);
    }
}