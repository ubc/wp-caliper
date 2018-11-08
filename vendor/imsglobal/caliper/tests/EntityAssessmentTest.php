<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assessment\AssessmentItem;


/**
 * @requires PHP 5.6.28
 */
class EntityAssessmentTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                ->setName(
                    'Quiz One'
                )
                ->setItems(
                    [
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/1'))
                        ,
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/2'))
                        ,
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3'))
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
                ->setDatePublished(
                    new \DateTime('2016-08-15T09:30:00.000Z'))
                ->setDateToActivate(
                    new \DateTime('2016-08-16T05:00:00.000Z'))
                ->setDateToShow(
                    new \DateTime('2016-08-16T05:00:00.000Z'))
                ->setDateToStartOn(
                    new \DateTime('2016-08-16T05:00:00.000Z'))
                ->setDateToSubmit(
                    new \DateTime('2016-09-28T11:59:59.000Z'))
                ->setMaxAttempts(
                    2
                )
                ->setMaxScore(
                    15.0
                )
                ->setMaxSubmits(
                    2
                )
                ->setVersion(
                    '1.0'
                )
        );
    }
}
