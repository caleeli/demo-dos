<?php

/**
 * ProcessMaker script: slfi-save-investor-emails
 *
 * BPMN scriptTask on Review bulk-email path. PM3: Save Investors emails.
 */

use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiScriptFactory;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\SaveInvestorEmails;

return (new SaveInvestorEmails(SlfiScriptFactory::repository()))->handle($data);
