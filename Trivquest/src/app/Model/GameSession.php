<?php
//This is my attempt at using reflection to essentially serialize and unserialize my Trivia object for this game.
//It is by no means perfect (probably not even that good) but with the limited time I had I did what I could at the time
//and I got to try something new that I had never even heard of before.
//Thanks to Emil Carlsson for suggesting the use of reflection.
class GameSession
{
    private $triviaSession;

    //property names
    private $questions;
    private $answers;
    private $currentQuestion;
    private $totalQuestions;
    private $removed;
    private $isRemoveTwoUsed;


    public function __construct()
    {
        $this->triviaSession = "trivia";

        $this->questions = 'questions';
        $this->answers = 'answers';
        $this->currentQuestion = 'currentQuestion';
        $this->totalQuestions = 'totalQuestions';
        $this->removed = 'removed';
        $this->isRemoveTwoUsed = 'isRemoveTwoUsed';
    }

    //Remove the trivia from the session
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

        //Get all properties in the trivia object (class)
        foreach ($triviaReflection->getProperties() as $triviaProperty)
        {
            //Set them to public basically (temporary)
            $triviaProperty->setAccessible(true);

            //If the property is the list of questions, repeat same steps as the trivia
            if($triviaProperty->getName() == $this->questions)
            {
                $questions = $triviaReflection->getProperty($this->questions);

                $questions->setAccessible(true);
                $questionsValue = $questions->getValue($trivia);
                $questions->setAccessible(false);

                $questionsArray = array();
                $questionArray = array();

                //Loop all the question objects
                foreach($questionsValue as $question)
                {
                    $questionReflection = new ReflectionClass($question);

                    //Every property in the question object(class)
                    foreach ($questionReflection->getProperties() as $questionProperty)
                    {
                        $questionProperty->setAccessible(true);
                        //If it is the list of answers, repeat the same steps as before
                        if($questionProperty->getName() == $this->answers)
                        {
                            $answers = $questionReflection->getProperty($this->answers);

                            $answers->setAccessible(true);
                            $answersValue = $answers->getValue($question);
                            $answers->setAccessible(false);

                            $answersArray = array();
                            $answerArray = array();

                            //Loop the answer objects
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

        //Save the "serialized" trivia to session without problem
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

        //get the trivia from session
        $triviaArray = $_SESSION[$this->triviaSession];

        //Create new trivia object with the saved questions->answers and lives as argument
        $trivia = new Trivia($this->recreateQuestions($triviaArray[$this->questions]), $triviaArray['lives']);

        $triviaReflection = new ReflectionClass($trivia);

        //Set the other saved property values with reflection
        foreach($triviaReflection->getProperties() as $prop)
        {
            $prop->setAccessible(true);

            if($prop->getName() == $this->currentQuestion)
            {
                $prop->setValue($trivia,$triviaArray[$this->currentQuestion]);
            }

            if($prop->getName() == $this->totalQuestions)
            {
                $prop->setValue($trivia,$triviaArray[$this->totalQuestions]);
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
            $question = new Question($questionsArray[$i]['question'], $this->recreateAnswers($questionsArray[$i][$this->answers]));

            $prop = new ReflectionProperty($question, $this->isRemoveTwoUsed);

            $prop->setAccessible(true);
            $prop->setValue($question, $questionsArray[$i][$this->isRemoveTwoUsed]);
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

            $prop = new ReflectionProperty($answer, $this->removed);

            $prop->setAccessible(true);
            $prop->setValue($answer, $answersArray[$i][$this->removed]);
            $prop->setAccessible(false);

            $answers[] = $answer;
        }

        return $answers;
    }
}