<?php

use IMSGlobal\Caliper\actions\Action;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\context\Context;
use IMSGlobal\Caliper\events\Event;
use IMSGlobal\Caliper\Sensor;

require_once 'CaliperTestCase.php';

class CustomContext extends Context {
    const CONTEXT = array(
        array(
            'query' => 'http://schema.org/query'
        ),
        'http://purl.imsglobal.org/ctx/caliper/v1p2'
    );
}

/**
 * @requires PHP 5.6.28
 */
class EnvelopeEventContextArrayTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject((new \IMSGlobal\Caliper\request\Envelope())
            ->setSensorId(new Sensor('https://example.edu/sensors/1'))
            ->setSendTime(new \DateTime('2017-11-15T10:15:01.000Z'))
            ->setData([
                (new Event('urn:uuid:3a648e68-f00d-4c08-aa59-8738e1884f2c'))
                    ->setContext(new CustomContext(CustomContext::CONTEXT))
                    ->setActor((new Person('https://example.edu/users/554433')))
                    ->setAction(new Action(Action::SEARCHED))
                    ->setEventTime(new \DateTime('2017-11-15T10:15:00.000Z'))
                    ->setObject((new Document('https://example.edu/terms/201601/courses/7/sections/1/resources/123')))
                    ->setExtensions([
                        'query' => 'Event or Entity'
                    ])
            ])
        );
    }
}
