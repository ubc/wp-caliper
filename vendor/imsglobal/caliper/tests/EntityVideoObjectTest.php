<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\media\VideoObject;


/**
 * @requires PHP 5.6.28
 */
class EntityVideoObjectTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new VideoObject('https://example.edu/videos/1225'))
                ->setMediaType(
                    'video/ogg'
                )
                ->setName(
                    'Introduction to IMS Caliper'
                )
                ->setVersion(
                    '1.1'
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
                ->setDuration(
                    'PT1H12M27S'
                )
        );
    }
}
