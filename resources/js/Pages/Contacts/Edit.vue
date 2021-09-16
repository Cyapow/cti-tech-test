<template>
  <app-layout>
    <template #header>
      <heading :breadcrumbs="[{name: 'Edit contact', href: route('contacts.edit', {contact: contact.id})}]" delete-action :object-id="contact.id" />
    </template>

    <contact :contact="contact" />
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
  props: ['contact', 'dataRoute'],
};
</script>
