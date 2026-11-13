<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use PHPUnit\Framework\TestCase;
use Tests\Unit\Projects\Slfi\FakeSlfiRepository;

final class SlfiInitializeSubmitScriptTest extends TestCase
{
  public function testWrapperSetsDatesAndContact(): void
  {
    global $slfiRepositoryPort;
    $slfiRepositoryPort = new FakeSlfiRepository();
    $data = [
      'APPLICATION' => 'app-42',
      '_user' => ['id' => '9', 'firstname' => 'Tax', 'lastname' => 'User'],
    ];
    $result = include dirname(__DIR__, 3) . '/projects/slfi/scripts/slfi-initialize-submit.php';
    $this->assertSame('tax@example.com', $result['SLFI_CONTACT_INFORMATION']);
    $this->assertSame('Tax User', $result['SLFI_SUBMITTER']);
    unset($slfiRepositoryPort);
  }
}
