<template>
  <div
    aria-live="assertive"
    class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-50"
  >
    <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
      <transition
        v-for="(item, index) in visibleNotifications"
        :key="index"
        enter-active-class="transform ease-out duration-300 transition"
        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
        leave-active-class="transition ease-in duration-300"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          class="
            max-w-sm
            w-full
            bg-white
            shadow-lg
            rounded-lg
            pointer-events-auto
            ring-1 ring-black ring-opacity-5
            overflow-hidden
          "
          @mouseover="item.timer.pause()"
          @mouseout="item.timer.resume()"
        >
          <div class="p-4">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <CheckCircleIcon v-if="item.style === 'success'" class="h-6 w-6 text-green-400" aria-hidden="true" />
                <ExclamationCircleIcon v-if="item.style === 'danger'" class="h-6 w-6 text-red-500" aria-hidden="true" />
              </div>
              <div class="ml-3 w-0 flex-1 pt-0.5">
                <p
                  class="text-sm font-medium font-bold"
                  :class="{
                    'text-green-500': item.style === 'success',
                    'text-red-500': item.style === 'danger',
                  }"
                >
                  {{ item.title }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                  {{ item.message }}
                </p>
              </div>
              <div class="ml-4 flex-shrink-0 flex">
                <button
                  class="
                    bg-white
                    rounded-md
                    inline-flex
                    text-gray-400
                    hover:text-gray-500
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                  "
                  @click="close(item.id)"
                >
                  <span class="sr-only">Close</span>
                  <XIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>
            </div>
          </div>
          <div class="h-2 relative w-full overflow-hidden">
            <div
              :ref="`progress_${item.id}`"
              class="w-full h-full absolute"
              :class="{ 'bg-green-500': item.style === 'success', 'bg-red-500': item.style === 'danger' }"
              :style="`width:${item.percentage}`"
            ></div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/outline';
import { XIcon } from '@heroicons/vue/solid';

const timer = function (close, updateProgress, listItem) {
  let timeLeft = 3000;

  this.pause = function () {
    if (listItem.interval) {
      clearInterval(listItem.interval);
    }
  };

  this.resume = function () {
    if (!listItem.visible) {
      return;
    }
    listItem.interval = setInterval(() => {
      if (!listItem.visible) {
        this.pause();
        return close(listItem.id);
      }
      timeLeft -= 10;

      const percentage = (100 * timeLeft) / 3000;

      updateProgress(listItem.id, percentage);

      if (timeLeft <= 0) {
        this.pause();
        return close(listItem.id);
      }
    }, 10);
  };

  this.resume();
};

export default {
  components: {
    CheckCircleIcon,
    ExclamationCircleIcon,
    XIcon,
  },
  data() {
    return {
      list: [],
    };
  },
  computed: {
    flash() {
      return this.$page.props.flash;
    },
    visibleNotifications() {
      return this.list.filter((item) => item.visible);
    },
  },
  watch: {
    flash: {
      deep: true,
      handler(val, oldVal) {
        if (val && JSON.stringify(val) !== JSON.stringify(oldVal)) {
          this.add();
        }
      },
    },
  },
  mounted() {
    if (this.flash) {
      this.add();
    }
  },
  beforeUnmount() {
    console.log('unmount');
    this.list.forEach((item) => {
      item.timer?.pause();
    });
  },
  methods: {
    add() {
      const message = Object.assign({}, this.$page.props.flash);
      message.id = this.list.length;
      message.visible = true;
      message.timer = new timer(this.close, this.updateProgress, message);

      this.list.push(message);
    },
    close(id) {
      this.list[id].visible = false;
      delete this.list[id].timer;
    },
    updateProgress(id, percentage) {
      this.$refs[`progress_${id}`].style.width = `${percentage}%`;
    },
  },
};
</script>
