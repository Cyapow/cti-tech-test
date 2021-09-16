<template>
  <Link :href="route(`${dataRoute}.edit`, { contact: item.id })">{{
    item[column.key]
  }}</Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
  components: {
    Link,
  },
  props: {
    column: {
      type: Object,
      default: () => {},
    },
    item: {
      type: Object,
      default: () => {},
    },
    dataRoute: {
      type: String,
      default: '',
    },
    dataProp: {
      type: String,
      default: '',
    },
    bindings: {
      type: Object,
      default: () => {},
    },
  },
};
</script>
