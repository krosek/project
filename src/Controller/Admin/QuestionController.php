<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AdminBaseController
{
    /**
     * @Route("/admin/questions", name = "question")
     * @param QuestionRepository $questionRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function ListOfQuestions(QuestionRepository $questionRepository, PaginatorInterface $paginator, Request $request){

        $queryBuilder = $questionRepository->createQueryBuilder('question');
        if($request->query->getAlnum('filterValue')){
            $queryBuilder->where('question.text LIKE :text')->setParameter('text', '%'. $request->query->getAlnum('filterValue') .'%')
            ->orWhere('question.id LIKE :id')->setParameter('id', '%'. $request->query->getAlnum('filterValue') .'%');
        }
        $query = $queryBuilder->getQuery()->getResult();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('admin/question.html.twig', [
            'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/admin/create_question", name="create_question")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addQuestion(Request $request)
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Add Question';

        $em = $this->getDoctrine()->getManager();
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($question);
            $em->flush();
            $this->addFlash('notification', 'Question added');
            return $this->redirect($this->generateUrl("question"));
        }

        $forRender['form'] = $form->createView();

        return $this->render('admin/createquestion.html.twig', $forRender);
    }

    /**
     * @Route("/admin/question/delete/{id}", name = "question_delete")
     * @param Question $question
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove(Question $question){
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        $this->addFlash('notification', 'Question was deleted');
        return $this->redirect($this->generateUrl("question"));
    }

    /**
     * @Route("/admin/question/edit/{id}", name = "question_edit")
     * @param Request $request
     * @param Question $question
     * @return Response
     */
    public function edit(Request $request, Question $question){
        $em = $this->getDoctrine()->getManager();

        $originalAnswer = new ArrayCollection();
        foreach ($question->getAnswers() as $answer){
            $originalAnswer->add($answer);
        }

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach ($originalAnswer as $answer){
                if ($question->getAnswers()->contains($answer) === false) {
                    $em->remove($answer);
                }
            }
            $em->persist($question);
            $em->flush();
            $this->addFlash('notification', 'Question edited');
            return $this->redirect($this->generateUrl("question"));
        }


        return $this->render('admin/editquestion.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
