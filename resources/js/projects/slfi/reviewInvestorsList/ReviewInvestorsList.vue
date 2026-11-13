<template>
  <div class="slfi-review-list">
    <slfi-case-header
      title="Review Investors List"
      :current-date="localData.SLFI_CURRENT_DATE"
      :submitter="localData.SLFI_SUBMITTER"
      :expiration-date="localData.SLFI_EXPIRATION_DATE"
    />
    <slfi-investors-grid :rows="gridRows" />
    <motion-section
      :disabled-return="localData.SLFI_BACK_FORM === 1"
      @cancel="setFlag('CANCEL')"
      @return="setFlag('RETURN')"
      @save="emitSave"
      @submit-bulk="onBulkSubmit"
    />
  </div>
</template>

<script>
import SlfiCaseHeader from '../shared/components/SlfiCaseHeader.vue';
import SlfiInvestorsGrid from '../shared/components/SlfiInvestorsGrid.vue';
import ReviewInvestorsActions from './components/ReviewInvestorsActions.vue';

export default {
  name: 'ReviewInvestorsList',
  components: {
    SlfiCaseHeader,
    SlfiInvestorsGrid,
    'motion-section': ReviewInvestorsActions,
  },
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
    setFlag(flag) {
      this.$emit('input', { ...this.localData, SLFI_FLAG_CANCEL_CASE: flag });
    },
    emitSave() {
      this.$emit('input', { ...this.localData, SLFI_FLAG_CANCEL_CASE: '' });
    },
    onBulkSubmit() {
      this.$emit('input', { ...this.localData, SLFI_FLAG_CANCEL_CASE: '' });
      if (typeof this.submit === 'function') {
        this.submit();
      }
    },
  },
};
</script>
