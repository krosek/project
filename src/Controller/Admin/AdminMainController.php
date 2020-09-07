<?php


namespace App\Controller\Admin;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/admin/users", name = "admin_users")
     * @param UserRepository $userRepository
     * @return Response
     */
    public function createList(UserRepository $userRepository){
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users'=>$users
        ]);
    }

    /**
     * @Route("/admin/users/delete/{id}", name = "user_delete")
     */
    public function remove(User $user){
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl("admin_users"));
    }


}