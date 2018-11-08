<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\annotation\SharedAnnotation;
use IMSGlobal\Caliper\entities\reading\Document;


/**
 * @requires PHP 5.6.28
 */
class EntitySharedAnnotationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new SharedAnnotation('https://example.edu/users/554433/etexts/201/shares/1'))
                ->setAnnotator(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setAnnotated(
                    (new Document('https://example.edu/etexts/201.epub'))
                )
                ->setWithAgents(
                    [
                        (new Person('https://example.edu/users/657585'))
                        ,
                        (new Person('https://example.edu/users/667788'))
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T09:00:00.000Z'))
        );
    }
}
