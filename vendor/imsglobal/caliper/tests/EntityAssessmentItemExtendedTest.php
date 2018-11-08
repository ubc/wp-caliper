<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assessment\AssessmentItem;


/**
 * @requires PHP 5.6.28
 */
class EntityAssessmentItemExtendedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3'))
                ->setIsPartOf(
                    (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1'))
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDatePublished(
                    new \DateTime('2016-08-15T09:30:00.000Z'))
                ->setIsTimeDependent(
                    false
                )
                ->setMaxScore(
                    1.0
                )
                ->setMaxSubmits(
                    2
                )
                ->setExtensions(
                    [
                        'questionType' => 'Dichotomous',
                        'questionText' => 'Is a Caliper SoftwareApplication a subtype of Caliper Agent?',
                        'correctResponse' => 'yes'
                    ])
        );
    }
}
