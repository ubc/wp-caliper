<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\search\Query;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;


/**
 * @requires PHP 5.6.28
 */
class EntityQueryTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Query('https://example.edu/users/554433/search?query=IMS%20AND%20%28Caliper%20OR%20Analytics%29'))
                ->setCreator(
                    (new Person('https://example.edu/users/554433'))
                )
                ->setSearchTarget(
                    (new SoftwareApplication('https://example.edu/catalog'))
                )
                ->setSearchTerms("IMS AND (Caliper OR Analytics)")
                ->setDateCreated(
                    new \DateTime('2018-11-15T10:05:00.000Z'))
        );
    }
}
