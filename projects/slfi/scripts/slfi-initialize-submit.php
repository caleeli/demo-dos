<?php

/**
 * ProcessMaker script: slfi-initialize-submit
 *
 * BPMN scriptTask: initialize before Submit Investor Confirmation Form.
 * Consolidates PM3 Set Requestor, dates, min expiration, external form contact, app ids, logo.
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\InitializeSubmit;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\SetRequestor;

$repository = SlfiScriptFactory::repository();
$data = (new SetRequestor())->handle($data);

return (new InitializeSubmit($repository))->handle($data);
