<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\question\OpenEndedQuestion;


/**
 * @requires PHP 5.6.28
 */
class EntityOpenEndedQuestionTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new OpenEndedQuestion('https://example.edu/surveys/100/questionnaires/30/items/2/question'))
                ->setQuestionPosed('What would you change about your course?')
        );
    }
}

