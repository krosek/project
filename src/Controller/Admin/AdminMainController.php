<?php


namespace App\Controller\Admin;
use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
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
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function createList(UserRepository $userRepository, PaginatorInterface $paginator, Request $request){
        $queryBuilder = $userRepository->createQueryBuilder('user');
        if($request->query->getAlnum('filterValue')){
            $queryBuilder->where('user.id LIKE :id')->setParameter('id', '%'. $request->query->getAlnum('filterValue') .'%')
                ->orWhere('user.email LIKE :email')->setParameter('email', '%'. $request->query->getAlnum('filterValue') .'%')
                ->orWhere('user.surname LIKE :surname')->setParameter('surname', '%'. $request->query->getAlnum('filterValue') .'%')
                ->orWhere('user.name LIKE :name')->setParameter('name', '%'. $request->query->getAlnum('filterValue') .'%')
                ->orWhere('user.middleName LIKE :middleName')->setParameter('middleName', '%'. $request->query->getAlnum('filterValue') .'%');
        }
        $query = $queryBuilder->getQuery()->getResult();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('admin/users.html.twig', [
            'pagination'=>$pagination
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