<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\Forum;
use IMSGlobal\Caliper\entities\Message;
use IMSGlobal\Caliper\entities\reading\Document;
use IMSGlobal\Caliper\entities\Thread;


/**
 * @requires PHP 5.6.28
 */
class EntityMessageTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1/messages/3'))
                ->setCreators(
                    [
                        (new Person('https://example.edu/users/778899'))
                        ,
                    ]
                )
                ->setBody(
                    'The Caliper working group provides a set of Caliper Sensor reference implementations for the purposes of education and experimentation.  They have not been tested for use in a production environment.  See the Caliper Implementation Guide for more details.'
                )
                ->setReplyTo(
                    (new Message('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1/messages/2'))
                )
                ->setIsPartOf(
                    (new Thread('https://example.edu/terms/201601/courses/7/sections/1/forums/2/topics/1'))
                        ->setIsPartOf(
                            (new Forum('https://example.edu/terms/201601/courses/7/sections/1/forums/2'))
                        )
                )
                ->setAttachments(
                    [
                        (new Document('https://example.edu/etexts/201.epub'))
                            ->setName(
                                'IMS Caliper Implementation Guide'
                            )
                            ->setDateCreated(
                                new \DateTime('2016-10-01T06:00:00.000Z'))
                            ->setVersion(
                                '1.1'
                            )
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-11-15T10:15:30.000Z'))
        );
    }
}
