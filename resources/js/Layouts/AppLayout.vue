<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="min-h-screen bg-white">
    <div class="py-10">
      <header>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>
      <main>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <!-- Replace with your content -->
          <div class="px-4 py-8 sm:px-0">
            <slot />
          </div>
          <!-- /End replace -->
        </div>
      </main>
    </div>
  </div>
  <notification />
</template>

<script>
import Notification from "components/Notification";
export default {
  components: {
    Notification
  },
  setup() {
  },
}
</script>
