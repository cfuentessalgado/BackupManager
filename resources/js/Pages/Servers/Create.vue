<template>
  <Head title="Create Server" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2>Create New Server</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
              <BreezeValidationErrors class="mb-4" />
              <form @submit.prevent="form.post('/servers')">
                <div class="form-control">
                    <label for="name" class="label"><span class="label-text">Name</span></label>
                    <input type="text" name="name" class="input input-bordered" v-model="form.name">
                </div>
                <div class="form-control">
                    <label for="ip" class="label"><span class="label-text">IP Address</span></label>
                    <input type="text" name="ip" class="input input-bordered" v-model="form.ip">
                </div>
                <div class="form-control">
                    <label for="backup_username" class="label"><span class="label-text">Backup Username</span></label>
                    <input type="text" name="backup_username" class="input input-bordered" v-model="form.backup_username">
                </div>
                <button class="btn mt-4" type="submit">Create Server</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeValidationErrors,
    Head,
  },
  data() {
    return {
      form: this.$inertia.form({
        name: null,
        ip: null,
        backup_username: null,
      }),
    };
  },
};
</script>
