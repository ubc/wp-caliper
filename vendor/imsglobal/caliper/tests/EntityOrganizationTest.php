<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\agent\Organization;


/**
 * @requires PHP 5.6.28
 */
class EntityOrganizationTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new Organization('https://example.edu/colleges/1/depts/1'))
                ->setName(
                    'Computer Science Department'
                )
                ->setSubOrganizationOf(
                    (new Organization('https://example.edu/colleges/1'))
                        ->setName(
                            'College of Engineering'
                        )
                )
        );
    }
}
