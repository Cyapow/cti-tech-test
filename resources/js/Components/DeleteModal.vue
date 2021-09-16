<template>
  <teleport to="body">
    <transition leave-active-class="duration-100">
      <div v-show="show" class="fixed z-10 inset-0 overflow-y-auto" @close="close">
        <transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-100"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div
              class="
                inline-block
                align-bottom
                bg-white
                rounded-lg
                px-4
                pt-5
                pb-4
                text-left
                overflow-hidden
                shadow-xl
                transform
                transition-all
                sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6
              "
            >
              <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                <button
                  type="button"
                  class="
                    bg-white
                    rounded-md
                    text-gray-400
                    hover:text-gray-500
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                  "
                  @click="close"
                >
                  <span class="sr-only">Close</span>
                  <XIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>
              <div class="sm:flex sm:items-start">
                <div
                  class="
                    mx-auto
                    flex-shrink-0 flex
                    items-center
                    justify-center
                    h-12
                    w-12
                    rounded-full
                    bg-red-100
                    sm:mx-0 sm:h-10 sm:w-10
                  "
                >
                  <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ title }}
                  </h3>
                  <div class="mt-2">
                    <slot />
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <primary-button ref="completeButtonRef" type="button" class="ml-3" @click="$emit('delete')"
                  >Delete</primary-button
                >
                <secondary-button @click="close">Cancel</secondary-button>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </transition>
  </teleport>
</template>

<script>
import { onMounted, onUnmounted } from 'vue';
import { ExclamationIcon, XIcon } from '@heroicons/vue/outline';
import PrimaryButton from 'components/PrimaryButton';
import SecondaryButton from 'components/SecondaryButton';

export default {
  components: {
    SecondaryButton,
    PrimaryButton,
    ExclamationIcon,
    XIcon,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
    show: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['delete', 'close'],

  setup(props, { emit }) {
    const close = () => {
      emit('close');
      console.log('close');
    };

    const closeOnEscape = (e) => {
      if (e.key === 'Escape' && props.show) {
        close();
      }
    };

    onMounted(() => document.addEventListener('keydown', closeOnEscape));
    onUnmounted(() => {
      document.removeEventListener('keydown', closeOnEscape);
      document.body.style.overflow = null;
    });

    return {
      close,
    };
  },
};
</script>
