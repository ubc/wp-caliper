<?php
namespace IMSGlobal\Caliper\entities\lis;

use IMSGlobal\Caliper;

class Status extends Caliper\util\BasicEnum implements Caliper\entities\w3c\Status {
    const
        __default = '',
        ACTIVE = 'Active',
        DELETED = 'Deleted',
        INACTIVE = 'Inactive';
}
