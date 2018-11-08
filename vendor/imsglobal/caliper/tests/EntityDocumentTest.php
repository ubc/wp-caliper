<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\reading\Document;


/**
 * @requires PHP 5.6.28
 */
class EntityDocumentTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Document('https://example.edu/etexts/201.epub'))
                ->setName(
                    'IMS Caliper Implementation Guide'
                )
                ->setMediaType(
                    'application/epub+zip'
                )
                ->setCreators(
                    [
                        (new Person('https://example.edu/people/12345'))
                        ,
                        (new Person('https://example.com/staff/56789'))
                        ,
                    ]
                )
                ->setDateCreated(
                    new \DateTime('2016-08-01T06:00:00.000Z'))
                ->setDatePublished(
                    new \DateTime('2016-10-01T06:00:00.000Z'))
                ->setVersion(
                    '1.1'
                )
        );
    }
}
