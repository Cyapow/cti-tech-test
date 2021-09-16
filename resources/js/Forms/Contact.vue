<template>
  <form class="space-y-8 divide-y divide-gray-200" @submit.prevent="submitForm">
    <div class="space-y-8 divide-y divide-gray-200">
      <div>
        <section-header title="Contact information" />

        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <form-input id="first_name" v-model="form.first_name" label="First Name" :error="form.errors.first_name" />
          </div>
          <div class="sm:col-span-3">
            <form-input id="last_name" v-model="form.last_name" label="Last Name" :error="form.errors.last_name" />
          </div>
          <div class="sm:col-span-4">
            <form-input id="email" v-model="form.email" label="Email" :error="form.errors.email" />
          </div>
          <div class="sm:col-span-3">
            <form-input id="telephone" v-model="form.telephone" label="Telephone" :error="form.errors.telephone" />
          </div>
        </div>
      </div>
      <div class="pt-5">
        <div class="flex justify-end">
          <secondary-button @click.prevent="goBack">Cancel</secondary-button>
          <primary-button class="ml-3">Save</primary-button>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import PrimaryButton from 'components/PrimaryButton';
import SecondaryButton from 'components/SecondaryButton';
import FormInput from 'components/Form/Input';
import SectionHeader from 'components/Form/SectionHeader';
export default {
  components: {
    PrimaryButton,
    SecondaryButton,
    FormInput,
    SectionHeader,
  },
  props: {
    contact: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        _method: this.contact ? 'PUT' : 'POST',
        first_name: this.contact?.first_name,
        last_name: this.contact?.last_name,
        email: this.contact?.email,
        telephone: this.contact?.telephone,
      })
    };
  },
  methods: {
    submitForm() {
      if (this.contact) {
        this.form.post(
          route('contacts.update', { contact: this.contact.id }),
          {
            errorBag: 'updateContact',
            preserveScroll: true,
          }
        );
      } else {
        this.form.post(route('contacts.store'), {
          errorBag: 'createContact',
          preserveScroll: true,
        });
      }
    },
    goBack() {
      window.history.back();
    },
  },
};
</script>
