<template>
  <form-label v-if="label" :id="id" :label="label"><slot name="label" /></form-label>
  <div class="mt-1 flex relative" :class="{ 'rounded-md shadow-sm': hasPrefix }">
    <span
      v-if="hasPrefix"
      class="
        inline-flex
        items-center
        px-3
        rounded-l-md
        border border-r-0 border-gray-300
        bg-gray-50
        text-gray-500
        sm:text-sm
      "
    >
      <slot name="prefix" />
    </span>
    <input
      v-bind="$attrs"
      :id="id"
      v-model="value"
      :type="type"
      class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full min-w-0 sm:text-sm border-gray-300"
      :class="{
        'shadow-sm rounded-md': !hasPrefix,
        'flex-1 rounded-none rounded-r-md': hasPrefix,
        'border-gray-300': !hasError,
        'border-red-400': hasError,
      }"
      :aria-invalid="hasError ? true : null"
      :aria-describedby="hasError ? `${id}-error` : null"
    />
  </div>
  <help-text :help-text="helpText" />
  <input-error :id="`${id}-error`" :message="error" />
</template>

<script>
import FormLabel from 'components/Form/Label';
import HelpText from 'components/Form/HelpText';
import InputError from 'components/Form/InputError';
import { computed } from 'vue';

export default {
  components: {
    HelpText,
    FormLabel,
    InputError,
  },
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    hasError: {
      type: String,
      default: '',
    },
    modelValue: {
      type: String,
      default: '',
    },
    helpText: {
      type: String,
      default: '',
    },
    error: {
      type: String,
      default: '',
    },
    type: {
      type: String,
      default: 'text',
    },
  },

  emits: ['update:modelValue'],

  setup(props, { emit }) {
    const value = computed({
      get: () => props.modelValue,
      set: (value) => emit('update:modelValue', value),
    });

    return {
      value,
    };
  },
  computed: {
    hasPrefix() {
      return !!this.$slots.prefix;
    },
  },
};
</script>
