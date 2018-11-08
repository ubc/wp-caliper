<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\media\MediaLocation;


/**
 * @requires PHP 5.6.28
 */
class EntityMediaLocationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MediaLocation('https://example.edu/videos/1225'))
                ->setCurrentTime(
                    'PT30M54S'
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
        );
    }
}
