<?php
require_once 'CaliperTestCase.php';

use IMSGlobal\Caliper\entities\survey\Questionnaire;
use IMSGlobal\Caliper\entities\survey\QuestionnaireItem;


/**
 * @requires PHP 5.6.28
 */
class EntityQuestionnaireTest extends CaliperTestCase {
    function setUp() {
        parent::setUp();

        $this->setTestObject(
            (new Questionnaire('https://example.edu/surveys/100/questionnaires/30'))
                ->setItems([
                    (new QuestionnaireItem('https://example.edu/surveys/100/questionnaires/30/items/1')),
                    (new QuestionnaireItem('https://example.edu/surveys/100/questionnaires/30/items/2'))
                ])
                ->setDateCreated(new \DateTime('2018-08-01T06:00:00.000Z'))
        );
    }
}

