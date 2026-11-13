<template>
  <div class="slfi-investors-grid">
    <b-table
      small
      striped
      hover
      :items="rows"
      :fields="fields"
      show-empty
      empty-text="No investors loaded yet."
    />
  </div>
</template>

<script>
export default {
  name: 'SlfiInvestorsGrid',
  props: {
    rows: { type: Array, default: () => [] },
    tracking: { type: Boolean, default: false },
  },
  computed: {
    fields() {
      const base = [
        { key: 'SLFI_GRID_INVESTORS_EMAIL', label: 'Email' },
        { key: 'SLFI_GRID_INVESTORS_DISPLAY_NAME', label: 'Display Name' },
        { key: 'SLFI_GRID_INVESTORS_INVESTOR_NAME', label: 'Investor Name' },
        { key: 'SLFI_GRID_INVESTORS_INVESTOR_ID', label: 'Investor ID' },
        { key: 'SLFI_GRID_INVESTORS_CLASS', label: 'Class' },
      ];
      if (!this.tracking) {
        return base;
      }
      return base.concat([
        { key: 'SLFI_GRID_INVESTORS_SEND_DATE', label: 'Sent Date' },
        { key: 'SLFI_GRID_INVESTORS_STATUS', label: 'Status' },
      ]);
    },
  },
};
</script>
