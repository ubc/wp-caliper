<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\Forum;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\Thread;


/**
 * @requires PHP 5.6.28
 */
class EntityThreadTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1'))
                ->setName(
                    'Caliper Information Model'
                )
                ->setItems(
                    [
                        (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1/messages/1'))
                        ,
                        (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1/messages/2'))
                            ->setReplyTo(
                                (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1/messages/1'))
                            )
                        ,
                        (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1/messages/3'))
                            ->setReplyTo(
                                (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/1/topics/1/messages/2'))
                            )
                        ,
                    ]
                )
                ->setIsPartOf(
                    (new Forum('https://example.edu/terms/201601/courses/7/sections/1/forums/1'))
                        ->setName(
                            'Caliper Forum'
                        )
                        ->setIsPartOf(
                            (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                                ->setSubOrganizationOf(
                                    (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                                )
                        )
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDateModified(
                    new \DateTime('2016-09-02T11:30:00.000Z'))
        );
    }
}
