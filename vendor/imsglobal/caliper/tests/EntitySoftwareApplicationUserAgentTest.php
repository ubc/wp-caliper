<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\SoftwareApplication;


/**
 * @requires PHP 5.6.28
 */
class EntitySoftwareApplicationUserAgentTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new SoftwareApplication('urn:uuid:d71016dc-ed2f-46f9-ac2c-b93f15f38fdc'))
                ->setHost('https://example.edu')
                ->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36')
                ->setIpAddress('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
        );
    }
}
