# SLFI database (`slfi_`)

Tables mirror PM3 `PMT_SLFI_*` additional tables.

## `slfi_investors_data`

Investor rows per request (`APP_UID`), populated from upload and tracking updates.

| Column | Notes |
| --- | --- |
| `SID_UID` | PK, auto increment |
| `APP_UID` | Process request id |
| `SID_EMAIL` | Investor email(s) |
| `SID_DISPLAY_NAME` | Display name |
| `SID_INVESTOR_NAME` | Legal / fund name |
| `SID_INVESTOR_ID` | Investor identifier |
| `SID_CLASS` | Share class |
| `SID_STATUS` | Pending, Sent, Re-sent, Completed… |
| `SID_EXPIRATION_DATE` | Confirmation deadline |
| `SID_SEND_DATE` | Last notification timestamp |

## `slfi_investor_emails`

Outbound queue for bulk investor notifications (cron sends `SIE_SEND_EMAIL = NO` rows).

## `slfi_external_form_variables`

Key/value configuration (`EFV_VARIABLE`, `EFV_VALUE`) including `SLFI_CONTACT_INFORMATION`.

## `slfi_min_expiration_date`

Active row (`SME_STATUS = ACTIVE`) defines minimum days until expiration (`SME_DAYS`).

## `slfi_investors_zip_message_history`

Tracks zip/PDF mailings (`APP_NUMBER`, `IZM_DATE`) to throttle tracking UI actions.

## `slfi_notification_templates`

Notification catalog (`SBN_TASK_KEY`, `SBN_TYPE`, `SBN_SUBJECT`, `SBN_BODY`, `SBN_STATUS`) replacing PM3 plugin lookups.
