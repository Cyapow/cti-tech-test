<template>{{ value }}</template>

<script>
import get from 'lodash/get';
export default {
  inheritAttrs: false,
  props: {
    column: {
      type: Object,
      default: () => {},
    },
    item: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    value() {
      const value = parseFloat(get(this.item, this.column.key));
      if (typeof value !== 'number') {
        return value;
      }
      const formatter = new Intl.NumberFormat('en-GB', {
        style: 'currency',
        currency: 'GBP',
        minimumFractionDigits: 0,
      });
      return formatter.format(value);
    },
  },
};
</script>
