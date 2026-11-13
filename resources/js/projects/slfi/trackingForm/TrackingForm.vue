<template>
  <div class="slfi-tracking-form">
    <slfi-case-header
      title="Investors Confirmation Tracking Task"
      :current-date="localData.SLFI_CURRENT_DATE"
      :submitter="localData.SLFI_SUBMITTER"
      :expiration-date="localData.SLFI_EXPIRATION_DATE"
    />
    <div class="mb-3 d-flex flex-wrap gap-2">
      <b-button variant="primary" @click="onReminder">Send Reminder</b-button>
      <b-button
        variant="primary"
        :disabled="zipDisabled"
        @click="onSendZip"
      >
        Send Completed Investors PDFs
      </b-button>
    </div>
    <slfi-investors-grid :rows="gridRows" tracking />
    <b-button variant="primary" class="mt-3" @click="onSubmit">Submit</b-button>
  </div>
</template>

<script>
import SlfiCaseHeader from '../shared/components/SlfiCaseHeader.vue';
import SlfiInvestorsGrid from '../shared/components/SlfiInvestorsGrid.vue';

export default {
  name: 'TrackingForm',
  components: { SlfiCaseHeader, SlfiInvestorsGrid },
  props: {
    value: { type: Object, default: () => ({}) },
    submit: { type: Function, default: () => undefined },
  },
  computed: {
    localData() {
      return this.value || {};
    },
    gridRows() {
      return this.localData.SLFI_INVESTORS_GRID_TRACKING || [];
    },
    zipDisabled() {
      return Number(this.localData.SLFI_DISABLED_BUTTON_INVESTORS_ZIP) === 1;
    },
  },
  methods: {
    onReminder() {
      this.$emit('input', { ...this.localData, BTN_SEND_REMINDER: true });
    },
    onSendZip() {
      this.$emit('input', { ...this.localData, BTN_SEND_EMAIL_WITH_PDF: true });
    },
    onSubmit() {
      if (typeof this.submit === 'function') {
        this.submit();
      }
    },
  },
};
</script>
