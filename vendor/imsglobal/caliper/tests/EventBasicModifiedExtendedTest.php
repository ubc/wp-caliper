<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\events\Event;

/**
 * @requires PHP 5.6.28
 */
class EventBasicModifiedExtendedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Event('urn:uuid:5973dcd9-3126-4dcc-8fd8-8153a155361c'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::MODIFIED))
                ->setObject(
                    (new Document('https://example.edu/terms/201601/courses/7/sections/1/resources/123?version=3'))
                        ->setName(
                            'Course Syllabus'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-12T07:15:00.000Z'))
                        ->setDateModified(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setVersion(
                            '3'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setExtensions([
                    'archive' => [
                        [
                            'id' => 'https://example.edu/terms/201601/courses/7/sections/1/resources/123?version=2',
                            'type' => 'Document',
                            'dateCreated' => '2016-11-12T07:15:00.000Z',
                            'dateModified' => '2016-11-13T11:00:00.000Z',
                            'version' => '2',
                        ],
                        [
                            'id' => 'https://example.edu/terms/201601/courses/7/sections/1/resources/123?version=1',
                            'type' => 'Document',
                            'dateCreated' => '2016-11-12T07:15:00.000Z',
                            'version' => '1',
                        ],
                    ],
                ])
        );
    }
}
