# SLFI workflow

Source: `projects/slfi/bpmn/slfi-process.xml` (PM3 `SLFI Process`).

## Lanes

- **Tax** — upload, tracking, manual start.
- **Reviewer** — review list, gateway outcomes (Tax group assignment with self-service).

## Path

1. **Start** (none, `pm:allowInterstitial="true"`) → `slfi-initialize-submit`.
2. **Submit Investor Confirmation Form** — screen `slfi-upload-investors-confirmation-form`.
   - PM3 had a second dynaform step **Show Investors Confirmation** on the same task; PM4 keeps screen `slfi-show-investors-confirmation` as the parity surface (grid preview after `slfi-read-upload-investors` / `slfi-load-investors-grid`).
3. `slfi-read-upload-investors` → `slfi-send-notifications` → `slfi-load-investors-grid`.
4. **Review Investors List** — `slfi-review-investors-list`, assignment `user_group` **Tax**, self-service.
5. `slfi-save-investor-emails` → exclusive gateway (FEEL):
   - `SLFI_FLAG_CANCEL_CASE = ""` → tracking path.
   - `SLFI_FLAG_CANCEL_CASE = "RETURN"` → back to Submit.
   - Cancel (other values) → `slfi-clean-on-cancel` → end.
6. **Tracking Forms** — `slfi-tracking-form`, assignment `process_variable` `SLFI_TAX_USER`.
7. End events: **Completed** (tracking) or **Canceled**.

## Script inventory vs PM3 triggers (19)

| PM3 trigger | PM4 script / note |
| --- | --- |
| Set Requestor, Set current date, Set Min date…, Get Email…, Get application…, Get External Form Link, Set logo, Set year | `slfi-initialize-submit` |
| Read file, save… grid | `slfi-read-upload-investors` (debug `g::pr`/`die` removed) |
| Get data investors grid | `slfi-load-investors-grid` |
| Get Data Investors Grid Tracking + button flags | `slfi-load-tracking-grid` |
| Save Investors emails | `slfi-save-investor-emails` |
| Clean table when cancel | `slfi-clean-on-cancel` |
| Send Notifications | `slfi-send-notifications` (queue only; mailer TBD) |
| Set flag first dynaform | `slfi-set-flag-first-dynaform` |
| Remove Assign Screen | **Not implemented** (PM3 redirect hack) |
| Set Task Uid | folded into initialize (`TASK_UID`) |

## Deploy record

| Asset | id |
| --- | --- |
| process_id | `3` |
| screen ids | deployed by title (see `ai-docs/slfi/AGENTS.md` screen table) |
| script ids | deployed by title (see script table) |
