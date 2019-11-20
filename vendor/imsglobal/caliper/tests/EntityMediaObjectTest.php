<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\media\MediaObject;


/**
 * @requires PHP 5.6.28
 */
class EntityMediaObjectTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MediaObject('https://example.edu/media/54321'))
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
                ->setDuration('PT1H17M50S')
        );
    }
}
