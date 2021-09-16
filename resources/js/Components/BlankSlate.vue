<template>
  <div class="text-center">
    <h3 class="mt-2 text-sm font-medium text-gray-900"><slot /></h3>
    <p v-if="description" class="mt-1 text-sm text-gray-500">{{ description }}</p>
  </div>
</template>

<script>
export default {
  name: 'BlankSlate',
  props: ['description'],
};
</script>
