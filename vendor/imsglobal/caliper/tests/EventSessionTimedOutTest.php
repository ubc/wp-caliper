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
class EventSessionTimedOutTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new SessionEvent('urn:uuid:4e61cf6c-ffbe-45bc-893f-afe7ad4079dc'))
                ->setActor(
                    (new SoftwareApplication('https://example.edu'))
                )
                ->setAction(
                    new Action(Action::TIMED_OUT))
                ->setObject(
                    (new Session('https://example.edu/sessions/7d6b88adf746f0692e2e873308b78c60fb13a864'))
                        ->setUser(
                            (new Person('https://example.edu/users/112233'))
                        )
                        ->setDateCreated(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setStartedAtTime(
                            new \DateTime('2016-11-15T10:15:00.000Z'))
                        ->setEndedAtTime(
                            new \DateTime('2016-11-15T11:15:00.000Z'))
                        ->setDuration(
                            'PT3600S'
                        )
                )
                ->setEventTime(
                    new \DateTime('2016-11-15T11:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference())
        );
    }
}
