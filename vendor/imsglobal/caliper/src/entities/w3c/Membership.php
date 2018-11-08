<?php
namespace IMSGlobal\Caliper\entities\w3c;

interface Membership {
    /** @return \IMSGlobal\Caliper\entities\foaf\Agent */
    function getMember();

    /** @return Organization */
    function getOrganization();

    /** @return Role[] */
    function getRoles();

    /** @return Status */
    function getStatus();
}
