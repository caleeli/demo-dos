<?php

declare(strict_types=1);

namespace Tests\Unit\Projects\Slfi;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

final class FakeSlfiRepository implements SlfiRepositoryPort
{
  /** @var array<int, array<string, mixed>> */
  public array $investors = [];

  public int $minDays = 7;

  public string $contact = 'tax@example.com';

  public function deleteInvestorsByApplication(string $applicationUid): void
  {
    $this->investors = array_values(array_filter(
      $this->investors,
      static fn (array $row): bool => ($row['APP_UID'] ?? '') !== $applicationUid
    ));
  }

  public function insertInvestorRows(string $applicationUid, array $rows, string $expirationDate): void
  {
    foreach ($rows as $index => $row) {
      $this->investors[] = [
        'APP_UID' => $applicationUid,
        'SID_UID' => $index + 1,
        'SID_EMAIL' => $row['email'] ?? '',
        'SID_DISPLAY_NAME' => $row['displayName'] ?? '',
        'SID_INVESTOR_NAME' => $row['investorName'] ?? '',
        'SID_INVESTOR_ID' => $row['investorId'] ?? '',
        'SID_CLASS' => $row['className'] ?? '',
        'SID_STATUS' => 'Pending',
        'SID_SEND_DATE' => '',
      ];
    }
  }

  public function fetchInvestorsByApplication(string $applicationUid): array
  {
    return array_values(array_filter(
      $this->investors,
      static fn (array $row): bool => ($row['APP_UID'] ?? '') === $applicationUid
    ));
  }

  public function countInvestorsInStatuses(string $applicationUid, array $statuses): int
  {
    $count = 0;
    foreach ($this->fetchInvestorsByApplication($applicationUid) as $row) {
      if (in_array($row['SID_STATUS'] ?? '', $statuses, true)) {
        $count++;
      }
    }

    return $count;
  }

  public function countCompletedInvestors(string $applicationUid): int
  {
    $count = 0;
    foreach ($this->fetchInvestorsByApplication($applicationUid) as $row) {
      if (str_starts_with((string) ($row['SID_STATUS'] ?? ''), 'Completed')) {
        $count++;
      }
    }

    return $count;
  }

  public function fetchMinExpirationDays(): int
  {
    return $this->minDays;
  }

  public function fetchExternalFormVariable(string $variableName): string
  {
    return $variableName === 'SLFI_CONTACT_INFORMATION' ? $this->contact : '';
  }

  public function fetchNotificationTemplate(string $taskKey, string $notificationType): ?array
  {
    return [
      'subject' => 'Investor confirmation',
      'body' => 'Hello SLFI_INVESTOR_NAME SLFI_LINK_INVESTORS',
    ];
  }

  public function insertInvestorEmail(string $applicationUid, array $emailRow): void
  {
  }

  public function fetchLatestZipMessageDate(int $applicationNumber): ?string
  {
    return null;
  }
}
