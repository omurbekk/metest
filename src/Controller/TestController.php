<?php

namespace App\Controller;

use App\Entity\TestResult;
use App\Services\TestService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(TestService $testService): Response
    {
        return $this->render('test.html.twig', [
            'questions' => $testService->showQuestions(),
        ]);
    }

    #[Route('/submit', name: 'submit', methods: ['POST'])]
    public function submit(Request $request, TestService $testService): RedirectResponse
    {
        $testService->submitAnswers($request->request->all());
        return $this->redirectToRoute('results');
    }

    #[Route('/results', name: 'results')]
    public function results(EntityManagerInterface $em): Response
    {
        $results = $em->getRepository(TestResult::class)->getResults();
        return $this->render('results.html.twig', [
            'results' => $results,
        ]);
    }
}
