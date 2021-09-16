<template><img v-if="item[column.key]" :src="`/storage/${item[column.key]}`" class="max-h-40 max-w-full" /></template>

<script>
export default {
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
};
</script>
