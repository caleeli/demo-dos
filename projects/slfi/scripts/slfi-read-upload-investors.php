<?php

/**
 * ProcessMaker script: slfi-read-upload-investors
 *
 * BPMN scriptTask after Submit task. PM3: Read file, save it into the table and populate grid (no debug die).
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\ReadUploadInvestors;

return (new ReadUploadInvestors(SlfiScriptFactory::repository()))->handle($data);
