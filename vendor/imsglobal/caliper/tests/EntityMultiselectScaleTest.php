<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\scale\MultiselectScale;


/**
 * @requires PHP 5.6.28
 */
class EntityMultiselectScaleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new MultiselectScale('https://example.edu/scale/3'))
                ->setScalePoints(5)
                ->setItemLabels(['😁', '😀', '😐', '😕', '😞'])
                ->setItemValues(['superhappy', 'happy', 'indifferent', 'unhappy', 'disappointed'])
                ->setIsOrderedSelection(false)
                ->setMinSelections(1)
                ->setMaxSelections(5)
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}
