<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Agent;

/**
 * @requires PHP 5.6.28
 */
class EntityAgentTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Agent('https://example.edu/agents/99999'))
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
        );
    }
}
