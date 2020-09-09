<?php


namespace App\Controller\Admin;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
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
        $this->addFlash('notification', 'User was deleted');
        return $this->redirect($this->generateUrl("admin_users"));
    }

    /**
     * @Route("/admin/users/block/{id}", name = "user_blocking")
     */
    public function block(User $user){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($user);
        $user->setStatus('blocked');
        $em->flush();
        $this->addFlash('notification', 'User was blocked');
        return $this->redirect($this->generateUrl("admin_users"));
    }

    /**
     * @Route("/admin/users/unblock/{id}", name = "user_unblocking")
     */
    public function unblock(User $user){
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($user);
        $user->setStatus('active');
        $em->flush();
        $this->addFlash('notification', 'User was unblocked');
        return $this->redirect($this->generateUrl("admin_users"));
    }
}