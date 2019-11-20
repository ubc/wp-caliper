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
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\session\Session;
use IMSGlobal\Caliper\entities\Thread;
use IMSGlobal\Caliper\events\MessageEvent;
use IMSGlobal\Caliper\context\Context;

class CustomMessageContext extends Context {
    const CONTEXT = array(
        'id' => '@id',
        'type' => '@type',
        'caliper' => 'http://purl.imsglobal.org/caliper/',
        'verb' => 'http://purl.imsglobal.org/caliper/actions/',
        'xsd' => 'http://www.w3.org/2001/XMLSchema#',
        'ForumProfile' => 'caliper:profiles/ForumProfile',
        'MessageEvent' => 'caliper:MessageEvent',
        'Message' => 'caliper:Message',
        'Person' => 'caliper:Person',
        'actor' => ['@id' => 'caliper:actor', '@type' => '@id'],
        'action' => ['@id' => 'caliper:action', '@type' => '@vocab'],
        'edApp' => ['@id' => 'caliper:edApp', '@type' => '@id'],
        'object' => ['@id' => 'caliper:object', '@type' => '@id'],
        'profile' => ['@id' => 'caliper:profile', '@type' => '@vocab'],
        'body' => ['@id' => 'caliper:body', '@type' => 'xsd:string'],
        'dateCreated' => ['@id' => 'caliper:dateCreated', '@type' => 'xsd:dateTime'],
        'eventTime' => ['@id' => 'caliper:eventTime', '@type' => 'xsd:dateTime'],
        'Posted' => 'verb:Posted'
    );
}

/**
 * @requires PHP 5.6.28
 */
class EventMessagePostedInlineContextTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new MessageEvent('urn:uuid:0d015a85-abf5-49ee-abb1-46dbd57fe64e'))
                ->setContext(new CustomMessageContext(CustomMessageContext::CONTEXT))
                ->setActor(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setProfile(
                    new Profile(Profile::FORUM))
                ->setAction(
                    new Action(Action::POSTED))
                ->setObject(
                    (new Message('https://example.edu/sections/1/forums/2/topics/1/messages/2'))
                        ->setBody(
                            'What does Caliper Event JSON-LD look like?'
                        )
                        ->setDateCreated(
                            new \DateTime('2018-12-15T10:15:00.000Z'))
                )
                ->setEventTime(
                    new \DateTime('2018-12-15T10:15:00.000Z'))
                ->setEdApp(
                    (new SoftwareApplication('https://example.edu'))->makeReference()
                )
        );
    }
}
