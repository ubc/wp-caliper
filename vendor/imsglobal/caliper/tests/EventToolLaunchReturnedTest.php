<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\session\LtiSession;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\entities\link\LtiLink;
use IMSGlobal\Caliper\entities\link\Link;
use IMSGlobal\Caliper\events\ToolLaunchEvent;


/**
 * @requires PHP 5.6.28
 */
class EventToolLaunchReturnedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new ToolLaunchEvent('urn:uuid:a2e8b214-4d4a-4456-bb4c-099945749117'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::RETURNED))
                ->setObject(
                    (new SoftwareApplication('https://example.com/lti/tool'))
                )
                ->setEventTime(
                    new \DateTime('2018-11-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))
                )
                ->setReferrer(
                    (new LtiLink('https://tool.com/lti/123'))
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))
                        ->setCourseNumber("CPS 435-01")
                        ->setAcademicSession("Fall 2018")
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201801/courses/7/sections/1/rosters/1'))
                        ->setMember(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setOrganization(
                            (new Organization('https://example.edu/terms/201801/courses/7/sections/1'))->makeReference())
                        ->setRoles(
                            [new Role(Role::LEARNER)])
                        ->setStatus(
                            new Status(Status::ACTIVE))
                        ->setDateCreated(
                            new \DateTime('2018-08-01T06:00:00.000Z'))
                )
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setStartedAtTime(
                            new \DateTime('2018-11-15T10:00:00.000Z'))
                )
                ->setTarget(
                    (new Link('https://example.edu/terms/201801/courses/7/sections/1/pages/1'))
                )
                ->setFederatedSession(
                    (new LtiSession('https://example.edu/lti/sessions/b533eb02823f31024e6b7f53436c42fb99b31241'))
                        ->setUser(
                            (new Person('https://example.edu/users/554433'))
                        )
                        ->setDateCreated(
                            new \DateTime('2018-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2018-11-15T10:15:00.000Z'))
                )
        );
    }
}
