<template>
  <Head title="Server Detail" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Servers
        </h2>
        <Link
          :href="`/servers/${server.id}/folders/create`"
          class="btn btn-outline"
          >Add Folder</Link
        >
      </div>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
              <div class="tabs mb-4">
                <a
                  @click="
                    folderActive = true;
                    setupActive = false;
                  "
                  class="tab tab-lifted"
                  :class="{ 'tab-active': folderActive }"
                  >Folders</a
                >
                <a
                  @click="
                    folderActive = false;
                    setupActive = true;
                  "
                  class="tab tab-lifted"
                  :class="{ 'tab-active': setupActive }"
                  >Setup</a
                >
              </div>
              <section v-if="folderActive">
                <div
                  v-if="server.folders.length > 0"
                  class="overflow-x-auto mt-4"
                >
                  <table class="table w-full">
                    <thead>
                      <tr>
                        <th>Path</th>
                        <th>Schedule</th>
                        <th>Max Backups</th>
                        <th>Current Backups</th>
                        <th>Total Size</th>
                        <th>Show</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="folder in server.folders"
                        :key="folder.id"
                      >
                        <td v-text="folder.path"></td>
                        <td v-text="folder.schedule.label"></td>
                        <td v-text="folder.max_backups"></td>
                        <td v-text="folder.backups.length"></td>
                        <td v-text="sizeInMb(folder.total_size)+'MB'"></td>
                        <td>
                          <Link :href="`/folders/${folder.id}`" class="text-blue-600">show</Link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div v-else>
                  <p class="text-gray-600 font-semibold text-xl">
                    No folders configured to backup for this server
                  </p>
                </div>
              </section>
              <section v-if="setupActive">
                <p>
                  Copy the
                  <span class="bg-gray-200 rounded shadow px-1 py-1"
                    >public key</span
                  >
                  to the
                  <span class="bg-gray-200 rounded shadow px-1 py-1"
                    >authorized_keys</span
                  >
                  of the
                  <span class="font-semibold" v-text="server.ip"></span> server
                </p>
                <button
                  class="mt-4 btn"
                  @click="showPublicKey = !showPublicKey"
                >
                  {{ showPublicKey ? "Hide" : "Show" }} Public Key
                </button>
                <div
                  v-if="showPublicKey"
                  class="mt-4 px-1 py-1 bg-gray-100 rounded shadow break-words"
                  v-text="server.public_key"
                ></div>
              </section>
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
    server: Object,
  },
  data() {
    return {
      folderActive: true,
      setupActive: false,
      showPublicKey: false,
      folder: null,
    };
  },
  methods: {
    sizeInMb(size) {
      return Math.floor(size/1024/1024)
    }
  }
};
</script>
