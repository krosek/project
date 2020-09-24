<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AdminBaseController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('admin/question.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    /**
     * @Route("/create_question", name="create_question")
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

        if($form->isSubmitted()){
            $em->persist($question);
            $em->flush();
            $this->addFlash('notification', 'Question added');
            return $this->redirect($this->generateUrl("question"));
        }

        $forRender['form'] = $form->createView();

        return $this->render('admin/createquestion.html.twig', $forRender);
    }
}
