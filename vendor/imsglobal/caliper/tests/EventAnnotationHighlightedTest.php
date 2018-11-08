<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\annotation\HighlightAnnotation;
use IMSGlobal\Caliper\entities\annotation\TextPositionSelector;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\AnnotationEvent;


/**
 * @requires PHP 5.6.28
 */
class EventAnnotationHighlightedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new AnnotationEvent('urn:uuid:0067a052-9bb4-4b49-9d1a-87cd43da488a'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::HIGHLIGHTED))
                ->setObject(
                    (new Document('https://example.com/#/texts/imscaliperimplguide'))
                        ->setName(
                            'IMS Caliper Implementation Guide'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-10-01T06:00:00.000Z'))
                        ->setVersion(
                            '1.1'
                        )
                )
                ->setGenerated(
                    (new HighlightAnnotation('https://example.com/users/554433/texts/imscaliperimplguide/highlights?start=2300&end=2370'))
                        ->setAnnotator(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setAnnotated(
                            (new DigitalResource('https://example.com/#/texts/imscaliperimplguide'))->makeReference())
                        ->setSelection(
                            (new TextPositionSelector())
                                ->setStart(
                                    2300
                                )
                                ->setEnd(
                                    2370
                                )
                        )
                        ->setSelectionText(
                            'ISO 8601 formatted date and time expressed with millisecond precision.'
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.com/reader'))
                        ->setName(
                            'ePub Reader'
                        )
                        ->setVersion(
                            '1.2.3'
                        )
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber(
                            'CPS 435-01'
                        )
                        ->setAcademicSession(
                            'Fall 2016'
                        )
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2016-08-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.com/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:00:00.000Z'))
                )
        );
    }
}
