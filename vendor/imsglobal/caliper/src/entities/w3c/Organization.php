<?php
namespace IMSGlobal\Caliper\entities\w3c;

interface Organization {
    /** @return string */
    function getId();

    /** @return Organization */
    function getSubOrganizationOf();
}
