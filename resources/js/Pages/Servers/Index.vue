<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Servers</h2>
        <Link href="/servers/create" class="btn">Create Server</Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
              <table class="table w-full table-zebra">
                  <thead>
                      <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Ip</th>
                          <th>More</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="server in servers" v-bind:key="server.id">
                          <td v-text="server.id"></td>
                          <td v-text="server.name"></td>
                          <td v-text="server.ip"></td>
                          <td>
                              <Link :href="`/servers/${server.id}`" class="text-blue-600 hover:text-blue-500 hover:underline">details</Link>
                          </td>
                      </tr>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
  },
  props: {
    servers: Array,
  },
};
</script>
