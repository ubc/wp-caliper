<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assessment\AssessmentItem;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\response\MultipleResponseResponse;


/**
 * @requires PHP 5.6.28
 */
class EntityMultipleResponseResponseTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MultipleResponseResponse('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3/users/554433/responses/1'))
                ->setAttempt(
                    (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3/users/554433/attempts/1'))
                        ->setAssignee(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setAssignable(
                            (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3'))
                                ->setIsPartOf(
                                    (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                                )
                        )
                        ->setCount(
                            1
                        )
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:15:22.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T10:15:30.000Z'))
                )
                ->setDateCreated(
                    new \DateTime('2016-11-15T10:15:22.000Z'))
                ->setStartedAtTime(
                    new \DateTime('2016-11-15T10:15:22.000Z'))
                ->setEndedAtTime(
                    new \DateTime('2016-11-15T10:15:30.000Z'))
                ->setValues(
                    [
                        'A'
                        ,
                        'D'
                        ,
                        'E'
                        ,
                    ]
                )
        );
    }
}
