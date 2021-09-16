<template>
  <p v-if="helpText" class="mt-2 text-sm text-gray-500">{{ helpText }}</p>
</template>

<script>
export default {
  inheritAttrs: false,
  props: ['helpText'],
};
</script>
