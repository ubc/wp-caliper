<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Organization;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\lis\Membership;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\NavigationEvent;


/**
 * @requires PHP 5.6.28
 */
class EventNavigationNavigatedToThinnedTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new NavigationEvent('urn:uuid:71657137-8e6e-44f8-8499-e1c3df6810d2'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))->makeReference())
                ->setAction(
                    new Action(Action::NAVIGATED_TO))
                ->setObject(
                    (new DigitalResource('https://example.edu/terms/201601/courses/7/sections/1/pages/2'))->makeReference())
                ->setEventTime(
                    new \DateTime('2016-11-15T10:15:00.000Z'))
                ->setReferrer(
                    (new DigitalResource('https://example.edu/terms/201601/courses/7/sections/1/pages/1'))->makeReference())
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setGroup(
                    (new Organization('https://example.edu/terms/201601/courses/7/sections/1'))->makeReference())
                ->setMembership(
                    (new Membership('https://example.edu/terms/201601/courses/7/sections/1/rosters/1'))->makeReference())
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))->makeReference())
        );
    }
}
