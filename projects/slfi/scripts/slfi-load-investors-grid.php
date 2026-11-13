<?php

/**
 * ProcessMaker script: slfi-load-investors-grid
 *
 * BPMN scriptTask before Review / Show screens. PM3: Get data investors grid.
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\LoadInvestorsGrid;

return (new LoadInvestorsGrid(SlfiScriptFactory::repository()))->handle($data);
