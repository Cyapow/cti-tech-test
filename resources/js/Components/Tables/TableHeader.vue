<template>
  <th
    v-for="item in columns"
    :key="item.key"
    scope="col"
    class="px-6 py-3 text-left tracking-wider align-middle"
    :class="item.classes ?? null"
    :style="item.style ?? null"
  >
    <button
      v-if="item.sortable ?? false"
      class="text-xs font-medium text-gray-500 uppercase"
      @click="$emit('sort', item.key)"
    >
      {{ item.label }}
      <span
        v-if="sortingColumn === item.key"
        :class="[{ 'rotate-180': sortingAsc }, 'transition-all sort-triangle inline-flex transform']"
      />
    </button>
    <span v-else class="text-xs font-medium text-gray-500 uppercase">
      {{ item.label }}
    </span>
  </th>
</template>
<script>
export default {
  props: {
    columns: {
      type: Object,
      default: () => {},
    },
    sortingColumn: {
      type: String,
      default: '',
    },
    sortingAsc: {
      type: Boolean,
      default: false,
    },
    sortingDisabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['sort'],
};
</script>
