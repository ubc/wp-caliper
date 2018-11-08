<?php
namespace IMSGlobal\Caliper\entities\reading;

use IMSGlobal\Caliper\entities;

/**
 * Class Reading
 *
 * @deprecated 1.2
 * @package IMSGlobal\Caliper\entities\reading
 */
class Reading extends entities\DigitalResource {
    /**
     * Reading constructor.
     *
     * @deprecated 1.2
     * @param $id
     */
    public function __construct($id) {
        parent::__construct($id);
        $this->setType(new entities\DigitalResourceType(entities\DigitalResourceType::READING));
    }
}