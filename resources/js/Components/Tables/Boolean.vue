<template>
  <div
    class="h-4 w-4 rounded-full"
    :class="{ 'bg-red-400': !item[column.key], 'bg-green-400': item[column.key] }"
  ></div>
</template>

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
