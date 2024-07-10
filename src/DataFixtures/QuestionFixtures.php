<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $questionsData = [
            [
                'text' => '1 + 1 = ',
                'answers' => [
                    ['text' => '3', 'isCorrect' => false],
                    ['text' => '2', 'isCorrect' => true],
                    ['text' => '0', 'isCorrect' => false],
                ]
            ],
            [
                'text' => '2 + 2 = ',
                'answers' => [
                    ['text' => '4', 'isCorrect' => true],
                    ['text' => '3 + 1', 'isCorrect' => true],
                    ['text' => '10', 'isCorrect' => false],
                ]
            ],

        ];

        foreach ($questionsData as $qData) {
            $question = new Question();
            $question->setText($qData['text']);
            foreach ($qData['answers'] as $aData) {
                $answer = new Answer();
                $answer->setText($aData['text']);
                $answer->setIsCorrect($aData['isCorrect']);
                $answer->setQuestion($question);
                $manager->persist($answer);
            }
            $manager->persist($question);
        }

        $manager->flush();
    }
}
