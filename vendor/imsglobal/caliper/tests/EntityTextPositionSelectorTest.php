<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\annotation\TextPositionSelector;


/**
 * @requires PHP 5.6.28
 */
class EntityTextPositionSelectorTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();


        $this->setTestObject(
            (new TextPositionSelector())
                ->setStart(2300)
                ->setEnd(2370)
        );
    }
}
