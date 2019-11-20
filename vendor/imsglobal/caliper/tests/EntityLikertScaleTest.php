<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\scale\LikertScale;


/**
 * @requires PHP 5.6.28
 */
class EntityLikertScaleTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new LikertScale('https://example.edu/scale/2'))
                ->setScalePoints(4)
                ->setItemLabels(['Strongly Disagree', 'Disagree', 'Agree', 'Strongly Agree'])
                ->setItemValues(['-2', '-1', '1', '2'])
        );
    }
}
