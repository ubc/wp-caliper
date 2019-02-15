<?php
namespace IMSGlobal\Caliper\context;

class Context extends \IMSGlobal\Caliper\util\BasicEnum {
    const
        __default = '',
        CONTEXT = 'http://purl.imsglobal.org/ctx/caliper/v1p1',
        RESOURCE_MANAGEMENT_EXTENSION = 'http://purl.imsglobal.org/ctx/caliper/v1p1/ResourceManagementProfile-extension',
        SEARCH_PROFILE_EXTENSION = 'http://purl.imsglobal.org/ctx/caliper/v1p1/SearchProfile-extension',
        TOOL_LAUNCH_PROFILE_EXTENSION = 'http://purl.imsglobal.org/ctx/caliper/v1p1/ToolLaunchProfile-extension';

    private $propertyName = '@context';

    public function getPropertyName() {
        return $this->propertyName;
    }
}

