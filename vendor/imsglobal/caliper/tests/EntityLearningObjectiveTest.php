<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\assignable\AssignableDigitalResource;
use IMSGlobal\Caliper\entities\LearningObjective;


/**
 * @requires PHP 5.6.28
 */
class EntityLearningObjectiveTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new AssignableDigitalResource('https://example.edu/terms/201601/courses/7/sections/1/assign/2'))
                ->setName(
                    'Caliper Profile Design'
                )
                ->setDescription(
                    'Choose a learning activity and describe the actions, entities and events that comprise it.'
                )
                ->setLearningObjectives(
                    [
                        (new LearningObjective('https://example.edu/terms/201601/courses/7/sections/1/objectives/1'))
                            ->setName(
                                'Research techniques'
                            )
                            ->setDescription(
                                'Demonstrate ability to model a learning activity as a Caliper profile.'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-08-01T06:00:00.000Z'))
                        ,
                    ]
                )
                ->setDateToActivate(
                    new \DateTime('2016-11-10T11:59:59.000Z'))
                ->setDateToShow(
                    new \DateTime('2016-11-10T11:59:59.000Z'))
                ->setDateCreated(
                    new \DateTime('2016-11-01T06:00:00.000Z'))
                ->setDateToStartOn(
                    new \DateTime('2016-11-15T11:59:59.000Z'))
                ->setDateToSubmit(
                    new \DateTime('2016-11-14T11:59:59.000Z'))
                ->setMaxAttempts(
                    2
                )
                ->setMaxSubmits(
                    2
                )
                ->setMaxScore(
                    50.0
                )
        );
    }
}
