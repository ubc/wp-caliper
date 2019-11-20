<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\survey\QuestionnaireItem;
use IMSGlobal\Caliper\entities\question\OpenEndedQuestion;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\NavigationEvent;
use IMSGlobal\Caliper\entities\DigitalResourceCollection;
use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\media\VideoObject;


/**
 * @requires PHP 5.6.28
 */
class EventNavigationNavigatedToCollectionItemTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new NavigationEvent('urn:uuid:ff9ec22a-fc59-4ae1-ae8d-2c9463ee2f8f'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setProfile(
                    new Profile(Profile::MEDIA))
                ->setAction(
                    new Action(Action::NAVIGATED_TO))
                ->setObject(
                    (new DigitalResourceCollection('https://example.edu/terms/201601/courses/7/sections/1/resources/2'))
                        ->setName('Video Collection')
                        ->setKeywords(['collection', 'videos'])
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setDateModified(new \DateTime('2016-09-02T11:30:00.000Z')),
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setReferrer(
                    (new VideoObject('https://example.edu/videos/1225'))
                        ->setMediaType('video/ogg')
                        ->setName('Introduction to IMS Caliper')
                        ->setStorageName('caliper-intro.ogg')
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setDuration('PT1H12M27S')
                        ->setVersion('1.1')
                )
                ->setTarget(
                    (new VideoObject('https://example.edu/videos/5629'))
                        ->setMediaType('video/ogg')
                        ->setName('IMS Caliper Activity Profiles')
                        ->setStorageName('caliper-activity-profiles.ogg')
                        ->setDateCreated(new \DateTime('2016-08-01T06:00:00.000Z'))
                        ->setDuration('PT55M13S')
                        ->setVersion('1.1.1')
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
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:00:00.000Z'))
                )
        );
    }
}
