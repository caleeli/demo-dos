<?php

declare(strict_types=1);

namespace Tests\Unit\Projects\Slfi;

use PHPUnit\Framework\TestCase;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\SlfiProcessSupport;

final class SlfiProcessSupportTest extends TestCase
{
  public function testParseCsvUpload(): void
  {
    $csv = "email,display name,investor name,investor id,class\n"
      . "a@example.com,Alpha,Alpha Fund,1,A\n";
    $rows = SlfiProcessSupport::parseUploadedInvestors([
      'SLFI_UPLOAD_INVESTORS' => $csv,
    ]);
    $this->assertCount(1, $rows);
    $this->assertSame('a@example.com', $rows[0]['email']);
  }
}
