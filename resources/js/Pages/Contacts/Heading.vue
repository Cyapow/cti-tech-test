<template>
  <page-header
    title="Contacts"
    :breadcrumbs="[
      { name: 'Contacts', href: route('contacts.index') },
      ...breadcrumbs,
    ]"
  >
    <template #actions>
      <secondary-button v-if="addNew" :link="route(`contacts.create`)">
        <span> <PlusSmIcon class="h-5 w-5" /></span>
        Add new
      </secondary-button>
      <primary-button v-if="deleteAction" type="button" @click="confirmDeletion = true">
        <span> <TrashIcon class="h-4 w-4 mr-2" /></span>
        Delete
      </primary-button>
      <delete-modal
        v-if="deleteAction"
        :title="`Delete Contact`"
        :show="confirmDeletion"
        @close="confirmDeletion = false"
        @delete="deleteItem"
      >
        <p class="text-sm text-gray-500">Are you sure you want to delete this Contact?</p>
      </delete-modal>
    </template>
  </page-header>
</template>
<script>
import PageHeader from 'components/PageHeader';
import { PlusSmIcon, TrashIcon } from '@heroicons/vue/solid';
import SecondaryButton from 'components/SecondaryButton';
import PrimaryButton from 'components/PrimaryButton';
import DeleteModal from 'components/DeleteModal';

export default {
  components: {
    DeleteModal,
    SecondaryButton,
    PrimaryButton,
    PageHeader,
    PlusSmIcon,
    TrashIcon,
  },
  props: {
    bindings: {
      type: Object,
      default: () => {},
    },
    addNew: {
      type: Boolean,
      default: false,
    },
    deleteAction: {
      type: Boolean,
      default: false,
    },
    objectId: {
      type: Number,
      default: 0,
    },
    breadcrumbs: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      confirmDeletion: false,
    };
  },
  methods: {
    deleteItem() {
      this.processing = true;
      this.$inertia.delete(
        route(`contacts.destroy`, {
          ...this.bindings,
          contact: this.objectId,
          redirectIndex: true
        }),
        {
          onFinish: () => {
            this.confirmDeletion = false;
          },
        }
      );
    },
  },
};
</script>
