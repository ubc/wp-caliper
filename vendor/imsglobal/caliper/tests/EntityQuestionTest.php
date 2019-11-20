<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\question\Question;


/**
 * @requires PHP 5.6.28
 */
class EntityQuestionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Question('https://example.edu/question/1'))
                ->setQuestionPosed('How would you rate this?')
        );
    }
}

