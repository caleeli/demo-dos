<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Infrastructure\Persistence;

use ProcessMaker\Package\DemoDos\Projects\Slfi\Domain\Ports\SlfiRepositoryPort;

/**
 * RedBean or PDO-backed adapter for script tasks (no Laravel).
 */
final class PdoSlfiRepository implements SlfiRepositoryPort
{
  private const TABLE_INVESTORS = 'slfi_investors_data';

  private const TABLE_EMAILS = 'slfi_investor_emails';

  private const TABLE_EXTERNAL = 'slfi_external_form_variables';

  private const TABLE_MIN_EXPIRATION = 'slfi_min_expiration_date';

  private const TABLE_ZIP_HISTORY = 'slfi_investors_zip_message_history';

  private const TABLE_NOTIFICATIONS = 'slfi_notification_templates';

  public function deleteInvestorsByApplication(string $applicationUid): void
  {
    $this->execute(
      'DELETE FROM ' . self::TABLE_INVESTORS . ' WHERE APP_UID = ?',
      [$applicationUid]
    );
  }

  public function insertInvestorRows(string $applicationUid, array $rows, string $expirationDate): void
  {
    foreach ($rows as $row) {
      $this->execute(
        'INSERT INTO ' . self::TABLE_INVESTORS . ' (
          APP_UID, SID_EMAIL, SID_DISPLAY_NAME, SID_INVESTOR_NAME,
          SID_INVESTOR_ID, SID_CLASS, SID_STATUS, SID_EXPIRATION_DATE
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
        [
          $applicationUid,
          $row['email'] ?? '',
          $row['displayName'] ?? '',
          $row['investorName'] ?? '',
          $row['investorId'] ?? '',
          $row['className'] ?? '',
          'Pending',
          $expirationDate,
        ]
      );
    }
  }

  public function fetchInvestorsByApplication(string $applicationUid): array
  {
    return $this->select(
      'SELECT SID_UID, SID_EMAIL, SID_DISPLAY_NAME, SID_INVESTOR_NAME,
              SID_INVESTOR_ID, SID_CLASS, SID_STATUS, SID_SEND_DATE
       FROM ' . self::TABLE_INVESTORS . '
       WHERE APP_UID = ?
       ORDER BY SID_UID ASC',
      [$applicationUid]
    );
  }

  public function countInvestorsInStatuses(string $applicationUid, array $statuses): int
  {
    if ($statuses === []) {
      return 0;
    }
    $placeholders = implode(',', array_fill(0, count($statuses), '?'));
    $params = array_merge([$applicationUid], $statuses);
    $rows = $this->select(
      'SELECT COUNT(*) AS total FROM ' . self::TABLE_INVESTORS . '
       WHERE APP_UID = ? AND SID_STATUS IN (' . $placeholders . ')',
      $params
    );

    return (int) ($rows[0]['total'] ?? 0);
  }

  public function countCompletedInvestors(string $applicationUid): int
  {
    $rows = $this->select(
      'SELECT COUNT(*) AS total FROM ' . self::TABLE_INVESTORS . '
       WHERE APP_UID = ? AND SID_STATUS LIKE ?',
      [$applicationUid, 'Completed%']
    );

    return (int) ($rows[0]['total'] ?? 0);
  }

  public function fetchMinExpirationDays(): int
  {
    $rows = $this->select(
      'SELECT SME_DAYS FROM ' . self::TABLE_MIN_EXPIRATION . ' WHERE SME_STATUS = ? LIMIT 1',
      ['ACTIVE']
    );

    return (int) ($rows[0]['SME_DAYS'] ?? 0);
  }

  public function fetchExternalFormVariable(string $variableName): string
  {
    $rows = $this->select(
      'SELECT EFV_VALUE FROM ' . self::TABLE_EXTERNAL . ' WHERE EFV_VARIABLE = ? LIMIT 1',
      [$variableName]
    );

    return (string) ($rows[0]['EFV_VALUE'] ?? '');
  }

  public function fetchNotificationTemplate(string $taskKey, string $notificationType): ?array
  {
    $rows = $this->select(
      'SELECT SBN_SUBJECT, SBN_BODY FROM ' . self::TABLE_NOTIFICATIONS . '
       WHERE SBN_TASK_KEY = ? AND SBN_TYPE = ? AND SBN_STATUS = ? LIMIT 1',
      [$taskKey, $notificationType, 'ACTIVE']
    );
    if ($rows === []) {
      return null;
    }

    return [
      'subject' => (string) ($rows[0]['SBN_SUBJECT'] ?? ''),
      'body' => (string) ($rows[0]['SBN_BODY'] ?? ''),
    ];
  }

  public function insertInvestorEmail(string $applicationUid, array $emailRow): void
  {
    $this->execute(
      'INSERT INTO ' . self::TABLE_EMAILS . ' (
        APP_UID, SIE_DISPLAY_NAME, SIE_INVESTOR_EMAIL, SIE_SUBJECT, SIE_BODY,
        SIE_TEMPLATE, SIE_SID_UID, SIE_STATUS, SIE_SEND_EMAIL
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
      [
        $applicationUid,
        $emailRow['displayName'] ?? '',
        $emailRow['investorEmail'] ?? '',
        $emailRow['subject'] ?? '',
        $emailRow['body'] ?? '',
        $emailRow['template'] ?? 'SLFIEmailTemplate.html',
        $emailRow['sidUid'] ?? 0,
        $emailRow['status'] ?? 'Sent',
        $emailRow['sendEmail'] ?? 'NO',
      ]
    );
  }

  public function fetchLatestZipMessageDate(int $applicationNumber): ?string
  {
    $rows = $this->select(
      'SELECT IZM_DATE FROM ' . self::TABLE_ZIP_HISTORY . '
       WHERE APP_NUMBER = ? ORDER BY IZM_UID DESC LIMIT 1',
      [$applicationNumber]
    );
    if ($rows === []) {
      return null;
    }

    return (string) ($rows[0]['IZM_DATE'] ?? null);
  }

  /**
   * @param array<int, mixed> $params
   * @return array<int, array<string, mixed>>
   */
  private function select(string $sql, array $params = []): array
  {
    if (isset($GLOBALS['slfiRepositoryFake']) && $GLOBALS['slfiRepositoryFake'] instanceof SlfiRepositoryPort) {
      return $GLOBALS['slfiRepositoryFake']->fetchInvestorsByApplication((string) ($params[0] ?? ''));
    }
    if (class_exists('\R')) {
      return \R::getAll($sql, $params);
    }

    return [];
  }

  /**
   * @param array<int, mixed> $params
   */
  private function execute(string $sql, array $params = []): void
  {
    if (isset($GLOBALS['slfiRepositoryFake']) && $GLOBALS['slfiRepositoryFake'] instanceof SlfiRepositoryPort) {
      return;
    }
    if (class_exists('\R')) {
      \R::exec($sql, $params);
    }
  }
}
