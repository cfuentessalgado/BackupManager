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
                <div v-if="server.folders.length > 0">
                  <div
                    v-for="folder in server.folders"
                    :key="folder.id"
                    tabindex="0"
                    class="
                      collapse
                      w-96
                      border
                      rounded-box
                      border-base-300
                      mb-2
                    "
                  >
                    <div
                      class="
                        collapse-title
                        text-xl
                        font-medium
                        flex
                        justify-between
                      "
                    >
                      <span v-text="folder.path"></span>
                      <span
                        v-text="`${folder.schedule.label} ${folder.hour ?? ''}`"
                      ></span>
                    </div>
                    <div class="collapse-content">
                      <p>
                        Ignored Patterns: {{ folder.ignore_patterns.join(",") }}
                      </p>
                      <p>
                        Backup Patterns: {{ folder.backup_patterns.join(",") }}
                      </p>
                      <p>Schedule: {{ folder.schedule.description }}</p>
                      <p>Time: {{ folder.hour }}</p>
                    </div>
                  </div>
                </div>
                <div v-else>
                <p class="text-gray-600 font-semibold text-xl">
                  No folders configured to backup for this server
                </p>
              </div>
              </section>
              <section v-if="setupActive">
                <p>Copy the <span class="bg-gray-200 rounded shadow px-1 py-1">public key</span> to the <span class="bg-gray-200 rounded shadow px-1 py-1">authorized_keys</span> of the <span class="font-semibold" v-text="server.ip"></span> server</p>
                <button class="mt-4 btn" @click="showPublicKey=!showPublicKey">{{showPublicKey?'Hide':'Show'}} Public Key</button>
                <div v-if="showPublicKey" class="mt-4 px-1 py-1 bg-gray-100 rounded shadow break-words" v-text="server.public_key"></div>
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
      showPublicKey:false
    };
  },
};
</script>
