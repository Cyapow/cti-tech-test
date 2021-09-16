<template>
  <p v-show="message" :id="id" class="mt-2 text-sm text-red-600">
    {{ message }}
  </p>
</template>

<script>
export default {
  props: ['id', 'message'],
};
</script>
