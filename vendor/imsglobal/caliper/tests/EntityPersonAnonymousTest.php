<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\SoftwareApplication;
use IMSGlobal\Caliper\entities\SystemIdentifier;
use IMSGlobal\Caliper\entities\SystemIdentifierType;
use IMSGlobal\Caliper\entities\agent\Person;


/**
 * @requires PHP 5.6.28
 */
class EntityPersonAnonymousTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            Person::makeAnonymous()
        );
    }
}
