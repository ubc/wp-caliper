<?php

namespace IMSGlobal\Caliper\entities;

interface Referrable {
    /** @return $this|\IMSGlobal\Caliper\entities\Entity */
    function makeReference();
}
