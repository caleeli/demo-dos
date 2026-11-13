# slfi

SLFI investor confirmation workflow migrated from PM3 `SLFI_Process-9.pmx`.

## Architecture

- [database.md](./architecture/database.md)
- [workflow.md](./architecture/workflow.md)
- [frontend.md](./architecture/frontend.md) — package build: [screen-builder.md](../screen-builder.md)

## BPMN

| File | Process name | process_id |
| --- | --- | --- |
| `projects/slfi/bpmn/slfi-process.xml` | SLFI Process | `3` |

## Screens (`pm:screenRef` → YAML → Vue)

| Screen title | YAML | Vue root |
| --- | --- | --- |
| `slfi-upload-investors-confirmation-form` | `projects/slfi/screens/slfi-upload-investors-confirmation-form.yaml` | `resources/js/projects/slfi/uploadInvestorsConfirmationForm/UploadInvestorsConfirmationForm.vue` |
| `slfi-show-investors-confirmation` | `projects/slfi/screens/slfi-show-investors-confirmation.yaml` | `resources/js/projects/slfi/showInvestorsConfirmation/ShowInvestorsConfirmation.vue` |
| `slfi-review-investors-list` | `projects/slfi/screens/slfi-review-investors-list.yaml` | `resources/js/projects/slfi/reviewInvestorsList/ReviewInvestorsList.vue` |
| `slfi-tracking-form` | `projects/slfi/screens/slfi-tracking-form.yaml` | `resources/js/projects/slfi/trackingForm/TrackingForm.vue` |

## Scripts (`pm:scriptRef` → PHP → use case)

| Script title | Wrapper | Use case |
| --- | --- | --- |
| `slfi-initialize-submit` | `projects/slfi/scripts/slfi-initialize-submit.php` | `InitializeSubmit`, `SetRequestor` |
| `slfi-read-upload-investors` | `projects/slfi/scripts/slfi-read-upload-investors.php` | `ReadUploadInvestors` |
| `slfi-load-investors-grid` | `projects/slfi/scripts/slfi-load-investors-grid.php` | `LoadInvestorsGrid` |
| `slfi-load-tracking-grid` | `projects/slfi/scripts/slfi-load-tracking-grid.php` | `LoadTrackingGrid` |
| `slfi-save-investor-emails` | `projects/slfi/scripts/slfi-save-investor-emails.php` | `SaveInvestorEmails` |
| `slfi-clean-on-cancel` | `projects/slfi/scripts/slfi-clean-on-cancel.php` | `CleanOnCancel` |
| `slfi-send-notifications` | `projects/slfi/scripts/slfi-send-notifications.php` | `SendNotifications` |
| `slfi-set-flag-first-dynaform` | `projects/slfi/scripts/slfi-set-flag-first-dynaform.php` | `SetFlagFirstDynaform` |

## Table prefix

`slfi_`

## Coverage report

- [slfi-coverage.html](./slfi-coverage.html)
