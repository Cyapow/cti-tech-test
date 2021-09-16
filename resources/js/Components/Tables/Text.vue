<template>{{ column.prefix || '' }}{{ value }}</template>

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
      return get(this.item, this.column.key);
    },
  },
};
</script>
