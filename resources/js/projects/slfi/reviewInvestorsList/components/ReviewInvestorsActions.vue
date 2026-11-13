<template>
  <div class="slfi-review-actions mt-3 d-flex flex-wrap gap-2">
    <b-button variant="outline-danger" @click="$emit('cancel')">Cancel Case</b-button>
    <b-button variant="secondary" @click="$emit('save')">Save</b-button>
    <b-button variant="warning" :disabled="disabledReturn" @click="$emit('return')">
      Re-upload Investors list
    </b-button>
    <b-button variant="primary" @click="$emit('submit-bulk')">Send Bulk email</b-button>
  </div>
</template>

<script>
export default {
  name: 'ReviewInvestorsActions',
  props: {
    disabledReturn: { type: Boolean, default: false },
  },
};
</script>
