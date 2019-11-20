<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\response\MultiselectResponse;


/**
 * @requires PHP 5.6.28
 */
class EntityMultiselectResponseTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new MultiselectResponse('https://example.edu/surveys/100/questionnaires/30/items/5/users/554433/responses/5'))
                ->setSelections([
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/1',
                    'https://example.edu/terms/201801/courses/7/sections/1/objectives/2'
                ])
                ->setStartedAtTime(new \DateTime('2018-08-01T05:55:48.000Z'))
                ->setEndedAtTime(new \DateTime('2018-08-01T06:00:00.000Z'))
                ->setDuration('PT4M12S')
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}

