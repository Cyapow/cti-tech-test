<template>
  <label :for="id" class="block text-sm font-medium text-gray-700 flex">{{ label }} <slot /></label>
</template>

<script>
export default {
  inheritAttrs: false,
  props: ['id', 'label'],
};
</script>
