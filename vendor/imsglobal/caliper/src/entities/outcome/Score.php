<?php

namespace IMSGlobal\Caliper\entities\outcome;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\assignable\Attempt;

class Score extends entities\Entity implements entities\Generatable {
    /** @var Attempt|null */
    private $attempt;
    /** @var float */
    private $maxScore;
    /** @var float */
    private $scoreGiven;
    /** @var entities\foaf\Agent */
    private $scoredBy;
    /** @var string */
    private $comment;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::SCORE));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'attempt' => $this->getAttempt(),
            'maxScore' => $this->getMaxScore(),
            'scoreGiven' => $this->getScoreGiven(),
            'scoredBy' => $this->getScoredBy(),
            'comment' => $this->getComment(),
        ]));
    }

    /** @return Attempt|null */
    public function getAttempt() {
        return $this->attempt;
    }

    /**
     * @param Attempt|null $attempt
     * @throws \InvalidArgumentException Attempt required
     * @return $this|Score
     */
    public function setAttempt($attempt) {
        if (is_null($attempt) || ($attempt instanceof Attempt)) {
            $this->attempt = $attempt;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Attempt expected');
    }

    /** @return float maxScore */
    public function getMaxScore() {
        return $this->maxScore;
    }

    /**
     * @param float $maxScore
     * @throws \InvalidArgumentException float required
     * @return $this|Score
     */
    public function setMaxScore($maxScore) {
        if (!is_float($maxScore)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->maxScore = $maxScore;
        return $this;
    }

    /** @return float scoreGiven */
    public function getScoreGiven() {
        return $this->scoreGiven;
    }

    /**
     * @param float $scoreGiven
     * @throws \InvalidArgumentException float required
     * @return $this|Score
     */
    public function setScoreGiven($scoreGiven) {
        if (!is_float($scoreGiven)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->scoreGiven = $scoreGiven;
        return $this;
    }

    /** @return entities\foaf\Agent scoredBy */
    public function getScoredBy() {
        return $this->scoredBy;
    }

    /**
     * @param entities\foaf\Agent $scoredBy
     * @return $this|Score
     */
    public function setScoredBy(entities\foaf\Agent $scoredBy) {
        $this->scoredBy = $scoredBy;
        return $this;
    }

    /** @return string comment */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @throws \InvalidArgumentException string required
     * @return $this|Score
     */
    public function setComment($comment) {
        if (!is_string($comment)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->comment = $comment;
        return $this;
    }
}
