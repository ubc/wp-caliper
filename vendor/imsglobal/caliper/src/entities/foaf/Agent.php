<?php
namespace IMSGlobal\Caliper\entities\foaf;

use IMSGlobal\Caliper\entities\Referrable;

/**
 *         From http://xmlns.com/foaf/spec/#term_Agent An agent (eg. person,
 *         group, software or physical artifact)
 *
 * TODO: Move from foaf to lis (which caliper-central issue?)
 *
 */
interface Agent extends Referrable {
    /** @return string */
    function getId();

    /** @return \IMSGlobal\Caliper\entities\Type */
    function getType();
}
