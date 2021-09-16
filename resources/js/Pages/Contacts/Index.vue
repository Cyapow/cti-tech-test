<template>
  <app-layout>
    <template #header>
      <heading add-new />
    </template>

    <table-list :columns="columns" :data="contacts" object-name="Contact" searchable data-route="contacts" data-prop="contact" edit-action delete-action />
  </app-layout>
</template>

<script>
import AppLayout from 'layouts/AppLayout.vue';
import TableList from 'components/TableList';
import Heading from './Heading';

const columns = [
  { label: 'First name', key: 'first_name', type: 'edit-link', sortable: true },
  { label: 'Last name', key: 'last_name', type: 'edit-link', sortable: true },
  { label: 'Email', key: 'email', sortable: true },
  { label: 'Telephone', key: 'telephone',  sortable: true },
];

export default {
  components: {
    TableList,
    AppLayout,
    Heading,
  },
  props: ['contacts'],
  setup() {
    return {
      columns,
    };
  },
};
</script>
