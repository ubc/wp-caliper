<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\Forum;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\Thread;


/**
 * @requires PHP 5.6.28
 */
class EntityForumTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Forum('https://example.edu/terms/201601/courses/7/sections/1/forums/1'))
                ->setName(
                    'Caliper Forum'
                )
                ->setItems(
                    [
                        (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1'))
                            ->setName(
                                'Caliper Information Model'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-11-01T09:30:00.000Z'))
                        ,
                        (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/2'))
                            ->setName(
                                'Caliper Sensor API'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-11-01T09:30:00.000Z'))
                        ,
                        (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/3'))
                            ->setName(
                                'Caliper Certification'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-11-01T09:30:00.000Z'))
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
