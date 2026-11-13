<?php

/**
 * ProcessMaker script: slfi-load-tracking-grid
 *
 * BPMN scriptTask before Tracking Forms. PM3 tracking grid + submit/zip button flags.
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\LoadTrackingGrid;

return (new LoadTrackingGrid(SlfiScriptFactory::repository()))->handle($data);
