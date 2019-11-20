<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\profiles\Profile;
use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\Forum;
use IMSGlobal\Caliper\entities\lis\CourseSection;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\lis\Role;
use IMSGlobal\Caliper\entities\lis\Status;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\ForumEvent;


/**
 * @requires PHP 5.6.28
 */
class EventForumSubscribedThinnedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new ForumEvent('urn:uuid:a2f41f9c-d57d-4400-b3fe-716b9026334e'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))->makeReference()
                )
                ->setProfile(
                    new Profile(Profile::FORUM))
                ->setAction(
                    new Action(Action::SUBSCRIBED))
                ->setObject(
                    (new Forum('https://example.edu/terms/201801/courses/7/sections/1/forums/1'))->makeReference()
                )
                ->setEventTime(
                    new \DateTime('2018-11-15T10:16:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu/forums'))->makeReference()
                )
                ->setGroup(
                    (new CourseSection('https://example.edu/terms/201801/courses/7/sections/1'))->makeReference()
                )
                ->setMembership(
                    (new Membership('https://example.edu/terms/201801/courses/7/sections/1/rosters/1'))->makeReference()
                )
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))->makeReference()
                )
        );
    }
}
