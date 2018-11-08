<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assignable\Attempt;


/**
 * @requires PHP 5.6.28
 */
class EntityAttemptTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                ->setAssignable(
                    (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                )
                ->setAssignee(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setCount(
                    1
                )
                ->setDateCreated(
                    new \DateTime('2016-11-15T10:05:00.000Z'))
                ->setStartedAtTime(
                    new \DateTime('2016-11-15T10:05:00.000Z'))
                ->setEndedAtTime(
                    new \DateTime('2016-11-15T10:55:30.000Z'))
                ->setDuration(
                    'PT50M30S'
                )
        );
    }
}
