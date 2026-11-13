<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports;

/**
 * Persistence port for slfi_* tables (PMT_SLFI_* parity).
 */
interface SlfiRepositoryPort
{
  public function deleteInvestorsByApplication(string $applicationUid): void;

  /**
   * @param array<int, array<string, mixed>> $rows
   */
  public function insertInvestorRows(string $applicationUid, array $rows, string $expirationDate): void;

  /**
   * @return array<int, array<string, mixed>>
   */
  public function fetchInvestorsByApplication(string $applicationUid): array;

  public function countInvestorsInStatuses(string $applicationUid, array $statuses): int;

  public function countCompletedInvestors(string $applicationUid): int;

  public function fetchMinExpirationDays(): int;

  public function fetchExternalFormVariable(string $variableName): string;

  /**
   * @return array<string, string>|null
   */
  public function fetchNotificationTemplate(string $taskKey, string $notificationType): ?array;

  /**
   * @param array<string, mixed> $emailRow
   */
  public function insertInvestorEmail(string $applicationUid, array $emailRow): void;

  public function fetchLatestZipMessageDate(int $applicationNumber): ?string;
}
