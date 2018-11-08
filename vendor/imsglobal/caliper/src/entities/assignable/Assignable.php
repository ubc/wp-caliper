<?php
namespace IMSGlobal\Caliper\entities\assignable;

interface Assignable {
    /** @return \DateTime */
    public function getDateToStartOn();

    /** @return \DateTime */
    public function getDateToActivate();

    /** @return \DateTime */
    public function getDateToShow();

    /** @return \DateTime */
    public function getDateToSubmit();

    /** @return int */
    public function getMaxAttempts();

    /** @return int */
    public function getMaxSubmits();
}