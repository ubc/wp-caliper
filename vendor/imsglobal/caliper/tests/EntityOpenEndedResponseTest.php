<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\response\OpenEndedResponse;


/**
 * @requires PHP 5.6.28
 */
class EntityOpenEndedResponseTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new OpenEndedResponse('https://example.edu/surveys/100/questionnaires/30/items/2/users/554433/responses/2'))
                ->setValue('I feel that ...')
                ->setStartedAtTime(new \DateTime('2018-08-01T05:55:48.000Z'))
                ->setEndedAtTime(new \DateTime('2018-08-01T06:00:00.000Z'))
                ->setDuration('PT4M12S')
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}

