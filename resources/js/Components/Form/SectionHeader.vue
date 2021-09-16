<template>
  <div>
    <h3 v-if="title" class="text-lg leading-6 font-medium text-gray-900">{{ title }}</h3>
    <p v-if="description" class="mt-1 text-sm text-gray-500">{{ description }}</p>
  </div>
</template>
<script>
export default {
  props: ['title', 'description'],
};
</script>
