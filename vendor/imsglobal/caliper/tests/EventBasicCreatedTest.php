<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\events\Event;


/**
 * @requires PHP 5.6.28
 */
class EventBasicCreatedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Event('urn:uuid:3a648e68-f00d-4c08-aa59-8738e1884f2c'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::CREATED))
                ->setObject(
                    (new Document('https://example.edu/terms/201601/courses/7/sections/1/resources/123'))
                        ->setName(
                            'Course Syllabus'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-12T07:15:00.000Z'))
                        ->setVersion(
                            '1'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
        );
    }
}
