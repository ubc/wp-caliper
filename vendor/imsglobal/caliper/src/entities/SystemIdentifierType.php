<?php
namespace IMSGlobal\Caliper\entities;

use IMSGlobal\Caliper;

class SystemIdentifierType extends Caliper\util\BasicEnum {
    const
        __default = '',
        LIS_SOURCED_ID = 'LisSourcedId',
        ONEROSTER_SOURCED_ID = 'OneRosterSourcedId',
        SIS_SOURCEDID = 'SisSourcedId',
        LTI_CONTEXT_ID = 'LtiContextId',
        LTI_DEPLOYMENT_ID = 'LtiDeploymentId',
        LTI_PLATFORM_ID = 'LtiPlatformId',
        LTI_TOOL_ID = 'LtiToolid',
        LTI_USERID = 'LtiUserId',
        EMAIL_ADDRESS = 'EmailAddress',
        ACCOUNT_USERNAME = 'AccountUserName',
        SYSTEM_ID = 'SystemId',
        OTHER = 'Other';
}
