<?php

/**
 * ProcessMaker script: slfi-clean-on-cancel
 *
 * BPMN scriptTask after Review cancel path. PM3: Clean table when cancel the case.
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\CleanOnCancel;

return (new CleanOnCancel(SlfiScriptFactory::repository()))->handle($data);
