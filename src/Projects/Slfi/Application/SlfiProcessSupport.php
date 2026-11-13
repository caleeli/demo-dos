<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Entities\InvestorRow;

/**
 * Pure helpers for SLFI process data shaping (no I/O).
 */
final class SlfiProcessSupport
{
  /**
   * @param array<string, mixed> $data
   */
  public static function applicationUid(array $data): string
  {
    return (string) ($data['requestId'] ?? $data['APP_UID'] ?? $data['APPLICATION'] ?? '');
  }

  /**
   * @param array<string, mixed> $data
   */
  public static function applicationNumber(array $data): int
  {
    return (int) ($data['_request']['case_number'] ?? $data['APP_NUMBER'] ?? $data['CASE_NUMBER'] ?? 0);
  }

  /**
   * @param array<string, mixed> $data
   * @return array<int, array<string, string>>
   */
  public static function parseUploadedInvestors(array $data): array
  {
    $upload = $data['SLFI_UPLOAD_INVESTORS'] ?? $data['SLFI_UPLOAD_INVESTORS_CSV'] ?? null;
    if (is_array($upload) && isset($upload['rows']) && is_array($upload['rows'])) {
      return self::normalizeRows($upload['rows']);
    }
    if (is_string($upload) && $upload !== '') {
      return self::parseCsv($upload);
    }
    if (is_array($upload) && self::isListOfRows($upload)) {
      return self::normalizeRows($upload);
    }

    return [];
  }

  /**
   * @param array<int, array<string, mixed>> $databaseRows
   * @return array<int, array<string, mixed>>
   */
  public static function buildReviewGrid(array $databaseRows): array
  {
    $grid = [];
    foreach ($databaseRows as $databaseRow) {
      $grid[] = InvestorRow::fromDatabaseRow($databaseRow)->toGridRow(false);
    }

    return $grid;
  }

  /**
   * @param array<int, array<string, mixed>> $databaseRows
   * @return array<int, array<string, mixed>>
   */
  public static function buildTrackingGrid(array $databaseRows, string $externalFormBase): array
  {
    $grid = [];
    foreach ($databaseRows as $databaseRow) {
      $row = InvestorRow::fromDatabaseRow($databaseRow)->toGridRow(true);
      $row['SLFI_GRID_INVESTORS_VIEW'] = $externalFormBase;
      $row['SLFI_GRID_INVESTORS_COPY_LINK_VALUE'] = $externalFormBase;
      $grid[] = $row;
    }

    return $grid;
  }

  /**
   * @param array<int, array<string, mixed>> $rows
   * @return array<int, array<string, string>>
   */
  private static function normalizeRows(array $rows): array
  {
    $normalized = [];
    foreach ($rows as $row) {
      $normalized[] = [
        'email' => (string) ($row['email'] ?? $row['SLFI_GRID_INVESTORS_EMAIL'] ?? ''),
        'displayName' => (string) ($row['displayName'] ?? $row['SLFI_GRID_INVESTORS_DISPLAY_NAME'] ?? ''),
        'investorName' => (string) ($row['investorName'] ?? $row['SLFI_GRID_INVESTORS_INVESTOR_NAME'] ?? ''),
        'investorId' => (string) ($row['investorId'] ?? $row['SLFI_GRID_INVESTORS_INVESTOR_ID'] ?? ''),
        'className' => (string) ($row['className'] ?? $row['SLFI_GRID_INVESTORS_CLASS'] ?? ''),
      ];
    }

    return $normalized;
  }

  /**
   * @param array<int, mixed> $upload
   */
  private static function isListOfRows(array $upload): bool
  {
    return isset($upload[0]) && is_array($upload[0]);
  }

  /**
   * @return array<int, array<string, string>>
   */
  private static function parseCsv(string $csv): array
  {
    $lines = preg_split('/\r\n|\r|\n/', trim($csv)) ?: [];
    if ($lines === []) {
      return [];
    }
    $header = str_getcsv(array_shift($lines) ?: '');
    $rows = [];
    foreach ($lines as $line) {
      if (trim($line) === '') {
        continue;
      }
      $values = str_getcsv($line);
      $mapped = [];
      foreach ($header as $index => $column) {
        $mapped[self::mapCsvColumn($column)] = (string) ($values[$index] ?? '');
      }
      if ($mapped['email'] !== '') {
        $rows[] = $mapped;
      }
    }

    return $rows;
  }

  private static function mapCsvColumn(string $column): string
  {
    $normalized = strtolower(trim($column));
    return match ($normalized) {
      'email' => 'email',
      'display name', 'displayname' => 'displayName',
      'investor name', 'investorname', 'name' => 'investorName',
      'investor id', 'investorid', 'id' => 'investorId',
      'class' => 'className',
      default => 'investorId',
    };
  }
}
