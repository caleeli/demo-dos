<?php

declare(strict_types=1);

namespace Tests\Unit\Projects\Slfi;

use PHPUnit\Framework\TestCase;
use ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases\ReadUploadInvestors;

final class ReadUploadInvestorsTest extends TestCase
{
  public function testReadsUploadIntoGrid(): void
  {
    $repository = new FakeSlfiRepository();
    $useCase = new ReadUploadInvestors($repository);
    $result = $useCase->handle([
      'APPLICATION' => 'app-1',
      'SLFI_UPLOAD_INVESTORS' => [
        ['email' => 'x@example.com', 'displayName' => 'X', 'investorName' => 'Fund X'],
      ],
      'SLFI_EXPIRATION_DATE' => '2026-12-31',
    ]);
    $this->assertCount(1, $result['SLFI_INVESTORS_GRID']);
    $this->assertSame(1, $result['SLFI_BACK_FORM']);
  }
}
