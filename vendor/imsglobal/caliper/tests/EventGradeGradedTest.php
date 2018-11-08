<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\outcome\Score;
use IMSGlobal\Caliper\events\GradeEvent;

/**
 * @requires PHP 5.6.28
 */
class EventGradeGradedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new GradeEvent('urn:uuid:a50ca17f-5971-47bb-8fca-4e6e6879001d'))
                ->setActor(
                    (new SoftwareApplication('https://example.edu/autograder'))
                        ->setVersion(
                            'v2'
                        )
                )
                ->setAction(
                    new Action(Action::GRADED))
                ->setObject(
                    (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                        ->setAssignee(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setAssignable(
                            (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                        )
                        ->setCount(
                            1
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:05:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:05:00.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T10:55:12.000Z'))
                        ->setDuration(
                            'PT50M12S'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:57:06.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setGenerated(
                    (new Score('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1/scores/1'))
                        ->setAttempt(
                            (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))->makeReference())
                        ->setMaxScore(
                            15.0
                        )
                        ->setScoreGiven(
                            10.0
                        )
                        ->setScoredBy(
                            (new SoftwareApplication('https://example.edu/autograder'))->makeReference())
                        ->setComment(
                            'auto-graded exam'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:56:00.000Z'))
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setAcademicSession(
                            'Fall 2016'
                        )
                )
        );
    }
}
