<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\scale\Scale;


/**
 * @requires PHP 5.6.28
 */
class EntityScaleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Scale('https://example.edu/scale/1'))
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}

