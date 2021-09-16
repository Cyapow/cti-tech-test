<template>
  <Link v-if="link" :href="link" :class="classes">
    <slot />
  </Link>
  <a v-else-if="href" :href="href" :class="classes">
    <slot />
  </a>
  <button v-else :type="type" :class="classes">
    <slot />
  </button>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3';

const classes =
  'inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm ' +
  'font-medium text-white bg-red-500 hover:bg-red-900 focus:outline-none focus:ring-2 ' +
  'focus:ring-offset-2 focus:ring-indigo-500';

export default {
  components: {
    Link,
  },
  props: {
    link: {
      type: String,
      default: '',
    },
    href: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'submit',
    },
  },
  setup() {
    return {
      classes,
    };
  },
};
</script>
