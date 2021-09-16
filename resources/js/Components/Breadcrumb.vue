<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div>
    <nav class="sm:hidden" aria-label="Back">
      <a href="#" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700" @click="goBack">
        <ChevronLeftIcon class="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
        Back
      </a>
    </nav>
    <nav class="hidden sm:flex" aria-label="Breadcrumb">
      <ol role="list" class="flex items-center space-x-4">
        <li v-for="(item, index) in breadcrumbs" :key="item.name">
          <div class="flex" :class="{ 'items-center': index > 0 }">
            <ChevronRightIcon v-if="index > 0" class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
            <Link
              :href="item.href"
              class="text-sm font-medium text-gray-500 hover:text-gray-700"
              :class="{ 'ml-4': index > 0 }"
              >{{ item.name }}</Link>
          </div>
        </li>
      </ol>
    </nav>
  </div>
</template>

<script>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';

export default {
  components: {
    ChevronRightIcon,
    Link,
    ChevronLeftIcon,
  },
  props: {
    breadcrumbs: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    goBack() {
      window.history.back();
    },
  },
};
</script>
