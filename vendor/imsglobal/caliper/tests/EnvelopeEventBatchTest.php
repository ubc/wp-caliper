<?php
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\annotation\BookmarkAnnotation;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\reading\WebPage;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\AnnotationEvent;
use IMSGlobal\Caliper\events\NavigationEvent;
use IMSGlobal\Caliper\events\ViewEvent;
use IMSGlobal\Caliper\Sensor;

require_once 'CaliperTestCase.php';


/**
 * @requires PHP 5.6.28
 */
class EnvelopeEventBatchTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSendTime(new \DateTime('2016-11-15T11:05:01.000Z'))
            ->setSensorId(new Sensor('https://example.edu/sensors/1'))
            ->setDataVersion('http://purl.imsglobal.org/ctx/caliper/v1p1')
            ->setData([
                (new NavigationEvent())
                    ->setActor((new Person('https://example.edu/users/554433'))
                    )
                    ->setAction(new Action(Action::NAVIGATED_TO))
                    ->setObject((new WebPage('https://example.edu/terms/201601/courses/7/sections/1/pages/2'))
                        ->setName('Learning Analytics Specifications')
                        ->setDescription('Overview of Learning Analytics Specifications with particular emphasis on IMS Caliper.')
                        ->setDateCreated(new \DateTime('2016-08-01T09:00:00.000Z')))
                    ->setEventTime(new \DateTime('2016-11-15T10:15:00.000Z'))
                    ->setReferrer(new WebPage('https://example.edu/terms/201601/courses/7/sections/1/pages/1'))
                    ->setEdApp(
                        (new SoftwareApplication('https://example.com/reader'))
                            ->setName(
                                'ePub Reader'
                            )
                            ->setVersion(
                                '1.2.3'
                            )

                    )
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber('CPS 435-01')
                        ->setAcademicSession('Fall 2016')
                    )
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles([new Role(Role::LEARNER)])
                        ->setStatus(new Status(Status::ACTIVE))
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z')))
                    ->setSession((new Session('https://example.com/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:00:00.000Z')))
                    ->setId('urn:uuid:72f66ce5-d2ec-44cc-bce5-41602e1015dc'),
                (new AnnotationEvent())
                    ->setActor((new Person('https://example.edu/users/554433'))
                    )
                    ->setAction(new Action(Action::BOOKMARKED))
                    ->setObject((new Document('https://example.com/#/texts/imscaliperimplguide'))
                        ->setName('IMS Caliper Implementation Guide')
                        ->setVersion('1.1')
                    )
                    ->setGenerated((new BookmarkAnnotation('https://example.com/users/554433/texts/imscaliperimplguide/bookmarks/1'))
                        ->setAnnotator((new Person('https://example.edu/users/554433'))->makeReference())
                        ->setAnnotated((new DigitalResource('https://example.com/#/texts/imscaliperimplguide/cfi/6/10!/4/2/2/2@0:0'))->makeReference())
                        ->setBookmarkNotes('Caliper profiles model discrete learning activities or supporting activities that facilitate learning.')
                        ->setDateCreated(new \DateTime('2016-11-15T10:20:00.000Z')))
                    ->setEventTime(new \DateTime('2016-11-15T10:20:00.000Z'))
                    ->setEdApp((new SoftwareApplication('https://example.com/reader'))
                        ->setName('ePub Reader')
                        ->setVersion('1.2.3')
                    )
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber('CPS 435-01')
                        ->setAcademicSession('Fall 2016')
                    )
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setMember(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setOrganization((new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles([new Role(Role::LEARNER)])
                        ->setStatus(new Status(Status::ACTIVE))
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z')))
                    ->setSession((new Session('https://example.com/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:00:00.000Z')))
                    ->setId('urn:uuid:c0afa013-64df-453f-b0a6-50f3efbe4cc0'),
                (new ViewEvent())
                    ->setActor((new Person('https://example.edu/users/554433'))
                    )
                    ->setAction(new Action(Action::VIEWED))
                    ->setObject((new Document('https://example.edu/etexts/201.epub'))
                        ->setName('IMS Caliper Implementation Guide')
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setDatePublished(new \DateTime('2016-10-01T06:00:00.000Z'))
                        ->setVersion('1.1')
                    )
                    ->setEventTime(new \DateTime('2016-11-15T10:21:00.000Z'))
                    ->setEdApp(
                        (new SoftwareApplication('https://example.com/reader'))
                            ->setName(
                                'ePub Reader'
                            )
                            ->setVersion(
                                '1.2.3'
                            )
                    )
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                        ->setCourseNumber('CPS 435-01')
                        ->setAcademicSession('Fall 2016')
                    )
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setMember(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setOrganization((new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles([new Role(Role::LEARNER)])
                        ->setStatus(new Status(Status::ACTIVE))
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z')))
                    ->setSession((new Session('https://example.com/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:00:00.000Z')))
                    ->setId('urn:uuid:94bad4bd-a7b1-4c3e-ade4-2253efe65172'),
            ])
        );
    }
}
