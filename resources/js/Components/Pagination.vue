<template>
  <nav
    v-if="data.last_page > 1"
    role="navigation"
    aria-label="Pagination Navigation"
    class="flex items-center justify-between"
  >
    <div class="flex justify-between flex-1 sm:hidden">
      <span
        v-if="data.current_page <= 1"
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          text-sm
          font-medium
          text-gray-300
          bg-white
          border border-gray-300
          cursor-default
          leading-5
          rounded-md
        "
      >
        &laquo; Previous
      </span>

      <Link
        v-else
        preserve-state
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          text-sm
          font-medium
          text-gray-700
          bg-white
          border border-gray-300
          leading-5
          rounded-md
          hover:text-gray-500
          focus:outline-none focus:ring
          ring-gray-300
          focus:border-blue-300
          active:bg-gray-100 active:text-gray-700
          transition
          ease-in-out
          duration-150
        "
        :href="data.prev_page_url"
      >
        &laquo; Previous
      </Link>

      <Link
        v-if="data.current_page < data.last_page"
        :href="data.next_page_url"
        preserve-state
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          ml-3
          text-sm
          font-medium
          text-gray-700
          bg-white
          border border-gray-300
          leading-5
          rounded-md
          hover:text-gray-500
          focus:outline-none focus:ring
          ring-gray-300
          focus:border-blue-300
          active:bg-gray-100 active:text-gray-700
          transition
          ease-in-out
          duration-150
        "
      >
        Next &raquo;
      </Link>
      <span
        v-else
        class="
          relative
          inline-flex
          items-center
          px-4
          py-2
          ml-3
          text-sm
          font-medium
          text-gray-300
          bg-white
          border border-gray-300
          cursor-default
          leading-5
          rounded-md
        "
      >
        Next &raquo;
      </span>
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-700 leading-5">
          Showing
          <span class="font-medium">{{ data.from }}</span>
          to
          <span class="font-medium">{{ data.to }}</span>
          of
          <span class="font-medium">{{ data.total }}</span>
          results
        </p>
      </div>

      <div>
        <span class="relative z-0 inline-flex shadow-sm rounded-md">
          <template v-for="(link, index) in data.links" :key="index">
            <span v-if="!link.url || link.active" aria-disabled="true" :aria-label="link.label">
              <span
                class="
                  relative
                  inline-flex
                  items-center
                  py-2
                  text-sm
                  font-medium
                  bg-white
                  border border-gray-300
                  cursor-default
                  leading-5
                "
                :class="{
                  '-ml-px font-bold text-gray-700': index > 0,
                  'rounded-l-md px-2 text-gray-300': index === 0,
                  'rounded-r-md px-2 text-gray-300': index === lastIndex,
                  'px-4': index > 0 && index < lastIndex,
                }"
                aria-hidden="true"
              >
                <chevron-left-icon v-if="index === 0" class="h-5 w-5 text-gray-400" />
                <chevron-right-icon
                  v-else-if="index === data.links.length - 1"
                  class="h-5 w-5 text-gray-400"
                />
                <span v-else>{{ link.label }}</span>
              </span>
            </span>

            <Link
              v-else
              :href="link.url"
              preserve-state
              class="
                relative
                inline-flex
                items-center
                py-2
                text-sm
                font-medium
                text-gray-700
                bg-white
                border border-gray-300
                leading-5
                hover:text-gray-500
                focus:z-10 focus:outline-none focus:ring
                ring-gray-300
                focus:border-blue-300
                active:bg-gray-100 active:text-gray-500
                transition
                ease-in-out
                duration-150
              "
              :class="{
                '-ml-px': index > 0,
                'rounded-l-md px-2': index === 0,
                'rounded-r-md px-2': index === lastIndex,
                'px-4': index > 0 && index < lastIndex,
              }"
              :aria-label="link.label"
            >
              <chevron-left-icon v-if="index === 0" class="h-5 w-5 text-gray-500" />
              <chevron-right-icon
                v-else-if="index === data.links.length - 1"
                class="h-5 w-5 text-gray-500"
              />
              <span v-else>{{ link.label }}</span>
            </Link>
          </template>
        </span>
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/solid';

export default {
  components: {
    Link,
    ChevronRightIcon,
    ChevronLeftIcon,
  },
  props: ['data'],
  computed: {
    lastIndex() {
      return this.data.links.length - 1;
    },
  },
};
</script>
