<template>
  <app-layout>
    <template #header>
      <heading :breadcrumbs="[{name: 'Create new', href: route('contacts.create')}]" />
    </template>

    <contact />
  </app-layout>
</template>

<script>
import AppLayout from 'layouts/AppLayout.vue';
import Heading from './Heading';
import Contact from 'forms/Contact';

export default {
  components: {
    Contact,
    AppLayout,
    Heading,
  },
  props: ['dataRoute'],
};
</script>
