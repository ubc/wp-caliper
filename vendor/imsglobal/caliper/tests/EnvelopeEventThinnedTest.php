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
class EnvelopeEventThinnedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSensorId(new Sensor('https://example.edu/sensors/1'))
            ->setSendTime(new \DateTime('2017-11-15T10:15:01.000Z'))
            ->setData([
                (new NavigationEvent('urn:uuid:71657137-8e6e-44f8-8499-e1c3df6810d2'))
                    ->setActor((new Person('https://example.edu/users/554433'))->makeReference())
                    ->setProfile(new Profile(Profile::GENERAL))
                    ->setAction(new Action(Action::NAVIGATED_TO))
                    ->setObject((new WebPage('https://example.edu/terms/201601/courses/7/sections/1/pages/2'))->makeReference())
                    ->setEventTime(new \DateTime('2017-11-15T10:15:00.000Z'))
                    ->setReferrer((new WebPage('https://example.edu/terms/201601/courses/7/sections/1/pages/1'))->makeReference())
                    ->setEdApp((new SoftwareApplication('https://example.edu'))->makeReference())
                    ->setGroup((new CourseSection('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                    ->setMembership((new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))->makeReference())
                    ->setSession((new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))->makeReference()),
            ])
        );
    }
}
