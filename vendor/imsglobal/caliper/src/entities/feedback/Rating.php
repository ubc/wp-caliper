<?php

namespace IMSGlobal\Caliper\entities\feedback;

use IMSGlobal\Caliper\entities\Entity;
use IMSGlobal\Caliper\entities\agent\Person;
use IMSGlobal\Caliper\entities\question\Question;
use IMSGlobal\Caliper\entities;

class Rating extends Entity implements entities\Referrable, entities\Generatable {
    /** @var Person */
    private $rater;
    /** @var Entity */
    private $rated;
    /** @var Question */
    private $question;
    /** @var string[] */
    private $selections = [];
    /** @var Comment */
    private $ratingComment;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::RATING));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'rater' => $this->getRater(),
            'rated' => $this->getRated(),
            'question' => $this->getQuestion(),
            'selections' => $this->getSelections(),
            'ratingComment' => $this->getRatingComment()
        ]));
    }

    /** @return Person|null rater */
    public function getRater() {
        return $this->rater;
    }

    /**
     * @param Person|null $rater
     * @return $this|Rating
     */
    public function setRater(Person $rater) {
        $this->rater = $rater;
        return $this;
    }

    /** @return Entity|null rated */
    public function getRated() {
        return $this->rated;
    }

    /**
     * @param Entity|null $rated
     * @return $this|Rating
     */
    public function setRated(Entity $rated) {
        $this->rated = $rated;
        return $this;
    }

    /** @return Question|null question */
    public function getQuestion() {
        return $this->question;
    }

    /**
     * @param Question|null $question
     * @return $this|Rating
     */
    public function setQuestion(Question $question) {
        $this->question = $question;
        return $this;
    }

    /** @return string[]|null selections */
    public function getSelections() {
        return $this->selections;
    }

    /**
     * @param string[]|null $selections
     * @return $this|Rating
     */
    public function setSelections($selections) {
        if (!is_null($selections)) {
            if (!is_array($selections)) {
                $selections = [$selections];
            }

            foreach ($selections as $selection) {
                if (!is_string($selection)) {
                    throw new \InvalidArgumentException(__METHOD__ . ': array of string expected');
                }
            }
        }

        $this->selections = $selections;
        return $this;
    }

    /** @return Comment|null ratingComment */
    public function getRatingComment() {
        return $this->ratingComment;
    }

    /**
     * @param Comment|null $ratingComment
     * @return $this|Rating
     */
    public function setRatingComment(Comment $ratingComment) {
        $this->ratingComment = $ratingComment;
        return $this;
    }
}
