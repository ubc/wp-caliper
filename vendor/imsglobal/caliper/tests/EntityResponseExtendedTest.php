<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assessment\AssessmentItem;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\response\Response;


/**
 * @requires PHP 5.6.28
 */
class EntityResponseExtendedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Response('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/6/users/554433/responses/1'))
                ->setAttempt(
                    (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/6/users/554433/attempts/1'))
                        ->setAssignee(
                            (new Person('https://example.edu/users/554433'))->makeReference()
                        )
                        ->setAssignable(
                            (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/6'))
                                ->setIsPartOf(
                                    (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                                )
                                ->setDateCreated(
                                    new \DateTime('2016-08-01T06:00:00.000Z'))
                                ->setDatePublished(
                                    new \DateTime('2016-08-15T09:30:00.000Z'))
                                ->setIsTimeDependent(false)
                                ->setMaxAttempts(2)
                                ->setMaxScore(5.0)
                                ->setMaxSubmits(2)
                                ->setExtensions([
                                    'questionType' => 'Short Answer',
                                    'questionText' => 'Define a Caliper Event and provide examples.'
                                ])
                        )
                        ->setCount(
                            1
                        )
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:15:46.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T10:17:20.000Z'))
                )
                ->setDateCreated(
                    new \DateTime('2016-11-15T10:15:46.000Z'))
                ->setStartedAtTime(
                    new \DateTime('2016-11-15T10:15:46.000Z'))
                ->setEndedAtTime(
                    new \DateTime('2016-11-15T10:17:20.000Z'))
                ->setExtensions([
                    'value' => 'A Caliper Event describes a relationship established between an actor and an object.  The relationship is formed as a result of a purposeful action undertaken by the actor in connection to the object at a particular moment. A learner starting an assessment, annotating a reading, pausing a video, or posting a message to a forum, are examples of learning activities that Caliper models as events.'
                ])
        );
    }
}
