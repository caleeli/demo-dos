<?php

/**
 * ProcessMaker script: slfi-send-notifications
 *
 * BPMN scriptTask after user tasks. PM3: Send Notifications (cron/mail integration deferred).
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\SendNotifications;

return (new SendNotifications())->handle($data);
