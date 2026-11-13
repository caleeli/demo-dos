<?php

/**
 * ProcessMaker script: slfi-set-flag-first-dynaform
 *
 * PM3: Set flag first dynaform (skip upload step after return).
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\SetFlagFirstDynaform;

return (new SetFlagFirstDynaform())->handle($data);
