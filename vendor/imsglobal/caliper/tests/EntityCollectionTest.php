<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\Collection;
use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\media\VideoObject;

/**
 * @requires PHP 5.6.28
 */
class EntityCollectionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Collection('https://example.edu/terms/201601/courses/7/sections/1/resources/2'))
                ->setItems(
                    [
                        (new VideoObject('https://example.edu/videos/1225'))
                            ->setMediaType('video/ogg')
                            ->setName('Introduction to IMS Caliper')
                            ->setStorageName('caliper-intro.ogg')
                            ->setDateCreated(new \DateTime('2019-08-01T06:00:00.000Z'))
                            ->setDuration('PT1H12M27S')
                            ->setVersion('1.1'),
                        (new VideoObject('https://example.edu/videos/5629'))
                            ->setMediaType('video/ogg')
                            ->setName('IMS Caliper Activity Profiles')
                            ->setStorageName('caliper-activity-profiles.ogg')
                            ->setDateCreated(new \DateTime('2019-08-01T06:00:00.000Z'))
                            ->setDuration('PT55M13S')
                            ->setVersion('1.1.1'),
                    ]
                )
                ->setDateCreated(new \DateTime('2019-08-01T06:00:00.000Z'))
                ->setDateModified(new \DateTime('2019-09-02T11:30:00.000Z'))
        );
    }
}
