<?php
use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\annotation\BookmarkAnnotation;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\CourseOffering;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\reading\WebPage;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\AssessmentEvent;
use IMSGlobal\Caliper\events\GradeEvent;
use IMSGlobal\Caliper\Sensor;
use IMSGlobal\Caliper\entities\SystemIdentifier;
use IMSGlobal\Caliper\entities\SystemIdentifierType;
use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\media\VideoObject;
use IMSGlobal\Caliper\entities\assessment\Assessment;
use IMSGlobal\Caliper\entities\assessment\AssessmentItem;
use IMSGlobal\Caliper\entities\assignable\Attempt;
use IMSGlobal\Caliper\entities\outcome\Score;

require_once 'CaliperTestCase.php';

/**
 * @requires PHP 5.6.28
 */
class EnvelopeMixedBatchTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSendTime(new \DateTime('2016-11-15T11:05:01.000Z'))
            ->setSensorId(new Sensor('https://example.edu/sensors/1'))
            ->setDataVersion('http://purl.imsglobal.org/ctx/caliper/v1p2')
            ->setData([
                (new Person('https://example.edu/users/554433'))
                    ->setOtherIdentifiers([
                        (new SystemIdentifier('example.edu:71ee7e42-f6d2-414a-80db-b69ac2defd4', new SystemIdentifierType(SystemIdentifierType::LIS_SOURCED_ID))),
                        (new SystemIdentifier('https://example.edu/users/554433', new SystemIdentifierType(SystemIdentifierType::LTI_USERID)))
                            ->setSource( (new SoftwareApplication('https://example.edu')) ),
                        (new SystemIdentifier('jane@example.edu', new SystemIdentifierType(SystemIdentifierType::EMAIL_ADDRESS)))
                            ->setSource( (new SoftwareApplication('https://example.edu'))->makeReference() ),
                        (new SystemIdentifier('4567', new SystemIdentifierType(SystemIdentifierType::SYSTEM_ID)))
                            ->setExtensions([
                                'com.examplePlatformVendor.identifier_type' => 'UserIdentifier'
                            ]),
                    ])
                    ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                    ->setDateModified(new \DateTime('2016-09-02T11:30:00.000Z')),
                (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))
                    ->setName('Quiz One')
                    ->setItems([
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/1')),
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/2')),
                        (new AssessmentItem('https://example.edu/terms/201601/courses/7/sections/1/assess/1/items/3')),
                    ])
                    ->setDateCreated(
                        new \DateTime('2016-08-01T06:00:00.000Z'))
                    ->setDateModified(
                        new \DateTime('2016-09-02T11:30:00.000Z'))
                    ->setDatePublished(
                        new \DateTime('2016-08-15T09:30:00.000Z'))
                    ->setDateToActivate(
                        new \DateTime('2016-08-16T05:00:00.000Z'))
                    ->setDateToShow(
                        new \DateTime('2016-08-16T05:00:00.000Z'))
                    ->setDateToStartOn(
                        new \DateTime('2016-08-16T05:00:00.000Z'))
                    ->setDateToSubmit(
                        new \DateTime('2016-09-28T11:59:59.000Z'))
                    ->setMaxAttempts(2)
                    ->setMaxScore(15.0)
                    ->setMaxSubmits(2)
                    ->setVersion('1.0'),
                (new SoftwareApplication('https://example.edu'))
                    ->setVersion('v2'),
                (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))
                    ->setAcademicSession('Fall 2016')
                    ->setCourseNumber('CPS 435-01')
                    ->setName('CPS 435 Learning Analytics, Section 01')
                    ->setOtherIdentifiers([
                        (new SystemIdentifier('example.edu:SI182-001-F16', new SystemIdentifierType(SystemIdentifierType::LIS_SOURCED_ID))),
                    ])
                    ->setCategory('seminar')
                    ->setSubOrganizationOf(
                        (new CourseOffering('https://example.edu/terms/201601/courses/7'))
                            ->setCourseNumber('CPS 435')
                    )
                    ->setDateCreated(
                        new \DateTime('2016-08-01T06:00:00.000Z')),
                (new AssessmentEvent())
                    ->setActor((new Person('https://example.edu/users/554433'))->makeReference())
                    ->setProfile(new Profile(Profile::ASSESSMENT))
                    ->setAction(new Action(Action::STARTED))
                    ->setEdApp((new SoftwareApplication('https://example.edu'))->makeReference())
                    ->setEventTime(new \DateTime('2016-11-15T10:15:00.000Z'))
                    ->setGenerated((new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                        ->setAssignable((new DigitalResource('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))->makeReference())
                        ->setAssignee(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setCount(1)
                        ->setDateCreated(new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:15:00.000Z'))
                    )
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setMember(((new Person('https://example.edu/users/554433'))->makeReference())
                        )
                        ->setOrganization((new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                        ->setRoles(new Role(Role::LEARNER))
                        ->setStatus(new Status(Status::ACTIVE))
                    )
                    ->setObject((new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))->makeReference())
                    ->setSession((new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(new \DateTime('2016-11-15T10:00:00.000Z'))
                    )
                    ->setId('urn:uuid:c51570e4-f8ed-4c18-bb3a-dfe51b2cc594'),
                (new AssessmentEvent('urn:uuid:dad88464-0c20-4a19-a1ba-ddf2f9c3ff33'))
                    ->setActor(
                        (new Person('https://example.edu/users/554433'))->makeReference())
                    ->setProfile(
                        new Profile(Profile::ASSESSMENT))
                    ->setAction(
                        new Action(Action::SUBMITTED))
                    ->setObject(
                        (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))->makeReference()
                    )
                    ->setEventTime(
                        new \DateTime('2016-11-15T10:25:30.000Z'))
                    ->setEdApp(
                        (new SoftwareApplication('https://example.edu'))->makeReference())
                    ->setGenerated((new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                        ->setAssignee(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setAssignable(
                            (new DigitalResource('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))->makeReference())
                        ->setCount(1)
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T10:55:12.000Z'))
                        ->setDuration('PT40M12S')
                    )
                    ->setGroup(
                        (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference()
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
                        (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                            ->setStartedAtTime(
                                new \DateTime('2016-11-15T10:00:00.000Z'))
                    ),
                (new GradeEvent('urn:uuid:a50ca17f-5971-47bb-8fca-4e6e6879001d'))
                    ->setActor(
                        (new SoftwareApplication('https://example.edu/autograder'))
                            ->setVersion(
                                'v2'
                            )
                    )
                    ->setProfile(
                        new Profile(Profile::GRADING))
                    ->setAction(
                        new Action(Action::GRADED))
                    ->setObject(
                        (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))
                            ->setAssignee(
                                (new Person('https://example.edu/users/554433'))->makeReference()
                            )
                            ->setAssignable(
                                (new Assessment('https://example.edu/terms/201601/courses/7/sections/1/assess/1?ver=v1p0'))->makeReference()
                            )
                            ->setCount(
                                1
                            )
                            ->setDateCreated(
                                new \DateTime('2016-11-15T10:15:00.000Z'))
                            ->setStartedAtTime(
                                new \DateTime('2016-11-15T10:15:00.000Z'))
                            ->setEndedAtTime(
                                new \DateTime('2016-11-15T10:55:12.000Z'))
                            ->setDuration('PT40M12S')
                    )
                    ->setEventTime(
                        new \DateTime('2016-11-15T10:57:06.000Z'))
                    ->setEdApp(
                        (new SoftwareApplication('https://example.edu'))->makeReference())
                    ->setGenerated(
                        (new Score('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1/scores/1'))
                            ->setAttempt(
                                (new Attempt('https://example.edu/terms/201601/courses/7/sections/1/assess/1/users/554433/attempts/1'))->makeReference())
                            ->setMaxScore(
                                15.0
                            )
                            ->setScoreGiven(
                                10.0
                            )
                            ->setScoredBy(
                                (new SoftwareApplication('https://example.edu/autograder'))->makeReference())
                            ->setComment(
                                'auto-graded exam'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-11-15T10:56:00.000Z'))
                    )
                    ->setGroup(
                        (new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference()
                    )
            ])
        );
    }
}
