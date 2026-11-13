<template>
  <div class="slfi-show-confirmation">
    <slfi-case-header
      title="Show Investors Confirmation"
      :current-date="localData.SLFI_CURRENT_DATE"
      :submitter="localData.SLFI_SUBMITTER"
      :show-expiration="false"
    />
    <slfi-investors-grid :rows="gridRows" />
    <b-button variant="primary" class="mt-3" @click="onContinue">Continue</b-button>
  </div>
</template>

<script>
import SlfiCaseHeader from '../shared/components/SlfiCaseHeader.vue';
import SlfiInvestorsGrid from '../shared/components/SlfiInvestorsGrid.vue';

export default {
  name: 'ShowInvestorsConfirmation',
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
      return this.localData.SLFI_INVESTORS_GRID || [];
    },
  },
  methods: {
    onContinue() {
      if (typeof this.submit === 'function') {
        this.submit();
      }
    },
  },
};
</script>
