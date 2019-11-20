<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\SystemIdentifier;
use IMSGlobal\Caliper\entities\SystemIdentifierType;
use IMSGlobal\Caliper\entities\agent\SoftwareApplication;


/**
 * @requires PHP 5.6.28
 */
class EntitySystemIdentifierTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new SystemIdentifier('https://example.edu/users/554433', new SystemIdentifierType(SystemIdentifierType::LTI_USERID)))
                ->setSource( (new SoftwareApplication('https://example.edu')) ),
        );
    }
}
