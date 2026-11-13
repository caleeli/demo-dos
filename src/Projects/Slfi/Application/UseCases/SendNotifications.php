<?php

declare(strict_types=1);

namespace ProcessMaker\Package\DemoDos\Projects\Slfi\Application\UseCases;

/**
 * Maps PM3 Send Notifications trigger to queued notification payloads in process data.
 */
final class SendNotifications
{
  /**
   * @param array<string, mixed> $data
   * @return array<string, mixed>
   */
  public function handle(array $data): array
  {
    $taskName = (string) ($data['_task']['name'] ?? $data['TASK_NAME'] ?? '');
    $flag = (string) ($data['SLFI_FLAG_CANCEL_CASE'] ?? '');
    $notificationType = 'SUBMIT';
    if ($taskName === 'Review Investors List' && $flag !== '') {
      $notificationType = $flag === 'RETURN' ? 'RETURN' : 'CANCEL';
    }

    $queue = $data['SLFI_NOTIFICATION_QUEUE'] ?? [];
    if (!is_array($queue)) {
      $queue = [];
    }
    $queue[] = [
      'type' => $notificationType,
      'task' => $taskName,
      'template' => 'SLFIEmailTemplate.html',
      'recipientUserId' => (string) ($data['SLFI_TAX_USER'] ?? ''),
    ];
    $data['SLFI_NOTIFICATION_QUEUE'] = $queue;

    return $data;
  }
}
