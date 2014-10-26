<?php
//This is my attempt at using reflection to essentially serialize and unserialize my Trivia object for this game.
//It is by no means perfect (probably not even that good) but with the limited time I had I did what I could at the time
//and I got to try something new that I had never even heard of before.
//Thanks to Emil Carlsson for suggesting the use of reflection.
class GameSession
{
    private $triviaSession;

    //property names


    public function __construct()
    {
        $this->triviaSession = "trivia";
    }

    public function unsetTrivia()
    {
        unset($_SESSION[$this->triviaSession]);
    }

    //Basically turns a Trivia object into a "storage-friendly" array to store in the session
    //My first attempt at using reflection so this is most likely not the most optimized way of solving this problem.
    public function saveTriviaToSession(Trivia $trivia)
    {
        $triviaArray = array();

        $triviaReflection = new ReflectionClass($trivia);

        foreach ($triviaReflection->getProperties() as $triviaProperty)
        {
            $triviaProperty->setAccessible(true);

            if($triviaProperty->getName() == 'questions')
            {
                $questions = $triviaReflection->getProperty('questions');

                $questions->setAccessible(true);
                $questionsValue = $questions->getValue($trivia);
                $questions->setAccessible(false);

                $questionsArray = array();
                $questionArray = array();

                foreach($questionsValue as $question)
                {
                    $questionReflection = new ReflectionClass($question);

                    foreach ($questionReflection->getProperties() as $questionProperty)
                    {
                        $questionProperty->setAccessible(true);
                        if($questionProperty->getName() == 'answers')
                        {
                            $answers = $questionReflection->getProperty('answers');

                            $answers->setAccessible(true);
                            $answersValue = $answers->getValue($question);
                            $answers->setAccessible(false);

                            $answersArray = array();
                            $answerArray = array();

                            foreach($answersValue as $answer)
                            {
                                $answerReflection = new ReflectionClass($answer);

                                foreach($answerReflection->getProperties() as $answerProperty)
                                {
                                    $answerProperty->setAccessible(true);
                                    $answerArray[$answerProperty->getName()] = $answerProperty->getValue($answer);
                                    $answerProperty->setAccessible(false);
                                }

                                $answersArray[] = $answerArray;
                            }
                            $questionArray[$questionProperty->getName()] = $answersArray;
                        }
                        else
                        {
                            $questionArray[$questionProperty->getName()] = $questionProperty->getValue($question);
                        }
                        $questionProperty->setAccessible(false);
                    }
                    $questionsArray[] = $questionArray;
                }
                $triviaArray[$triviaProperty->getName()] = $questionsArray;
            }
            else
            {
                $triviaArray[$triviaProperty->getName()] = $triviaProperty->getValue($trivia);
            }
            $triviaProperty->setAccessible(false);
        }

        $_SESSION[$this->triviaSession] = $triviaArray;
    }

    //Turns the Trivia array back into objects so the application can work with it
    //Again, probably not the most optimized
    public function loadTriviaFromSession()
    {
        if(!isset($_SESSION[$this->triviaSession]))
        {
            return null;
        }

        $triviaArray = $_SESSION[$this->triviaSession];

        $trivia = new Trivia($this->recreateQuestions($triviaArray['questions']), $triviaArray['lives']);

        $triviaReflection = new ReflectionClass($trivia);

        foreach($triviaReflection->getProperties() as $prop)
        {
            $prop->setAccessible(true);

            if($prop->getName() == 'currentQuestion')
            {
                $prop->setValue($trivia,$triviaArray['currentQuestion']);
            }

            if($prop->getName() == 'totalQuestions')
            {
                $prop->setValue($trivia,$triviaArray['totalQuestions']);
            }

            $prop->setAccessible(false);
        }

        return $trivia;
    }

    private function recreateQuestions($questionsArray)
    {
        $questions = Array();

        for($i = 0; $i < count($questionsArray); ++$i)
        {
            $question = new Question($questionsArray[$i]['question'], $this->recreateAnswers($questionsArray[$i]['answers']));

            $prop = new ReflectionProperty($question, 'isRemoveTwoUsed');

            $prop->setAccessible(true);
            $prop->setValue($question, $questionsArray[$i]['isRemoveTwoUsed']);
            $prop->setAccessible(false);

            $questions[] = $question;
        }

        return $questions;
    }

    private function recreateAnswers($answersArray)
    {
        $answers = Array();

        for($i = 0; $i < count($answersArray); ++$i)
        {
            $answer = new Answer($answersArray[$i]['answer'], $answersArray[$i]['isCorrect']);

            $prop = new ReflectionProperty($answer, 'removed');

            $prop->setAccessible(true);
            $prop->setValue($answer, $answersArray[$i]['removed']);
            $prop->setAccessible(false);

            $answers[] = $answer;
        }

        return $answers;
    }
}