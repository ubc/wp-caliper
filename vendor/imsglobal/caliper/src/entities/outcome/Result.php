<?php

namespace IMSGlobal\Caliper\entities\outcome;

use IMSGlobal\Caliper\entities;
use IMSGlobal\Caliper\entities\assignable\Attempt;

class Result extends entities\Entity implements entities\Generatable {
    /** @var Attempt|null */
    private $attempt;
    /** @var float */
    private $maxResultScore;
    /** @var float */
    private $resultScore;
    /** @var entities\foaf\Agent */
    private $scoredBy;
    /** @var string */
    private $comment;

    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\EntityType(entities\EntityType::RESULT));
    }

    public function jsonSerialize() {
        $serializedParent = parent::jsonSerialize();
        if (!is_array($serializedParent)) return $serializedParent;
        return $this->removeChildEntitySameContexts(array_merge($serializedParent, [
            'attempt' => $this->getAttempt(),
            'maxResultScore' => $this->getMaxResultScore(),
            'resultScore' => $this->getResultScore(),
            'comment' => $this->getComment(),
            'scoredBy' => $this->getScoredBy(),
        ]));
    }

    /** @return Attempt|null */
    public function getAttempt() {
        return $this->attempt;
    }

    /**
     * @param Attempt|null $attempt
     * @throws \InvalidArgumentException Attempt required
     * @return $this|Result
     */
    public function setAttempt($attempt) {
        if (is_null($attempt) || ($attempt instanceof Attempt)) {
            $this->attempt = $attempt;
            return $this;
        }

        throw new \InvalidArgumentException(__METHOD__ . ': Attempt expected');
    }

    /** @return float maxResultScore */
    public function getMaxResultScore() {
        return $this->maxResultScore;
    }

    /**
     * @param float $maxResultScore
     * @throws \InvalidArgumentException float required
     * @return $this|Result
     */
    public function setMaxResultScore($maxResultScore) {
        if (!is_float($maxResultScore)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->maxResultScore = $maxResultScore;
        return $this;
    }

    /** @return float resultScore */
    public function getResultScore() {
        return $this->resultScore;
    }

    /**
     * @param float $resultScore
     * @throws \InvalidArgumentException float required
     * @return $this|Result
     */
    public function setResultScore($resultScore) {
        if (!is_float($resultScore)) {
            throw new \InvalidArgumentException(__METHOD__ . ': float expected');
        }

        $this->resultScore = $resultScore;
        return $this;
    }

    /** @return string comment */
    public function getComment() {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @throws \InvalidArgumentException string required
     * @return $this|Result
     */
    public function setComment($comment) {
        if (!is_string($comment)) {
            throw new \InvalidArgumentException(__METHOD__ . ': string expected');
        }

        $this->comment = $comment;
        return $this;
    }

    /** @return entities\foaf\Agent scoredBy */
    public function getScoredBy() {
        return $this->scoredBy;
    }

    /**
     * @param entities\foaf\Agent $scoredBy
     * @return $this|Result
     */
    public function setScoredBy(entities\foaf\Agent $scoredBy) {
        $this->scoredBy = $scoredBy;
        return $this;
    }
}
