<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\events\SessionEvent;


/**
 * @requires PHP 5.6.28
 */
class EventSessionLoggedOutTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new SessionEvent('urn:uuid:a438f8ac-1da3-4d48-8c86-94a1b387e0f6'))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAction(
                    new Action(Action::LOGGED_OUT))
                ->setObject(
                    (new SoftwareApplication('https://example.edu'))
                        ->setVersion(
                            'v2'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T11:05:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
                ->setSession(
                    (new Session('https://example.edu/sessions/1f6442a482de72ea6ad134943812bff564a76259'))
                        ->setUser(
                            (new Person('https://example.edu/users/554433'))->makeReference())
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:00:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:00:00.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T11:05:00.000Z'))
                        ->setDuration(
                            'PT3000S'
                        )
                )
        );
    }
}
