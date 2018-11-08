<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\media\VideoObject;


/**
 * @requires PHP 5.6.28
 */
class EntityDigitalResourceCollectionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new DigitalResourceCollection('https://example.edu/terms/201601/courses/7/sections/1/resources/2'))
                ->setName(
                    'Video Collection'
                )
                ->setKeywords(
                    [
                        'collection'
                        ,
                        'videos'
                        ,
                    ]
                )
                ->setItems(
                    [
                        (new VideoObject('https://example.edu/videos/1225'))
                            ->setMediaType(
                                'video/ogg'
                            )
                            ->setName(
                                'Introduction to IMS Caliper'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-08-01T06:00:00.000Z'))
                            ->setDuration(
                                'PT1H12M27S'
                            )
                            ->setVersion(
                                '1.1'
                            )
                        ,
                        (new VideoObject('https://example.edu/videos/5629'))
                            ->setMediaType(
                                'video/ogg'
                            )
                            ->setName(
                                'IMS Caliper Activity Profiles'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-08-01T06:00:00.000Z'))
                            ->setDuration(
                                'PT55M13S'
                            )
                            ->setVersion(
                                '1.1.1'
                            )
                        ,
                    ]
                )
                ->setIsPartOf(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setSubOrganizationOf(
                            (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                        )
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
        );
    }
}
