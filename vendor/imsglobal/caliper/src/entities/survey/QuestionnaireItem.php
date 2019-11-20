<?php

namespace IMSGlobal\Caliper\entities\survey;

use IMSGlobal\Caliper\entities\DigitalResource;
use IMSGlobal\Caliper\entities\question\Question;
use IMSGlobal\Caliper\entities;

class QuestionnaireItem extends DigitalResource {
    /** @var Question|null */
    private $question;
    /** @var string[]|null */
    private $categories;
    /** @var float|null */
    private $weight;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::QUESTIONNAIRE_ITEM));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'question' => $this->getQuestion(),
            'categories' => $this->getCategories(),
            'weight' => $this->getWeight(),
        ]));
    }

    /** @return Question|null */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @param Question|null $question
     * @return QuestionnaireItem
     */
    public function setQuestion(Question $question) {
        $this->question = $question;
        return $this;
    }

    /** @return string[]|null */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * @param string[]|string|null $categories
     * @return QuestionnaireItem
     */
    public function setCategories($categories) {
        if (!is_null($categories)) {
            if (!is_array($categories)) {
                $categories = [$categories];
            }

            foreach ($categories as $category) {
                if (!is_string($category)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
                }
            }
        }

        $this->categories = $categories;
        return $this;
    }

    /** @return float weight */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @throws \InvalidArgumentException float required
     * @return QuestionnaireItem
     */
    public function setWeight($weight) {
        if (!is_float($weight)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->weight = $weight;
        return $this;
    }
}