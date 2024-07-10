<?php

namespace App\Services;

use App\Entity\Question;
use App\Entity\TestResult;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class TestService
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function submitAnswers(array $data): void
    {
        $results = [];
        foreach ($data as $questionId => $answerIds) {
            $question = $this->em->getRepository(Question::class)->find($questionId);
            $correctAnswers = $question->getAnswers()->filter(function ($answer) {
                return $answer->isCorrect();
            })->map(function ($answer) {
                return (string)$answer->getId();
            })->getValues();
            $results[$questionId] = array_diff($answerIds, $correctAnswers) === [];
        }
        $testResult = new TestResult();
        $testResult->setCreatedAt(new \DateTime());
        $testResult->setResults($results);

        $this->em->persist($testResult);
        $this->em->flush();
    }

    public function showQuestions(): array
    {
        $questions = $this->em->getRepository(Question::class)->findAll();
        shuffle($questions);
        foreach ($questions as $question) {
            $answers = $question->getAnswers()->toArray();
            shuffle($answers);
            $question->setAnswers(new ArrayCollection($answers));
        }
        return $questions;
    }
}