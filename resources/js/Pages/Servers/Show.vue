<template>
  <Head title="Server Detail" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Servers</h2>
        <Link :href="`/servers/${server.id}/folders/create`" class="btn btn-outline">Add Folder</Link>
      </div>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
              <div v-if="server.folders">
                <div
                  v-for="folder in server.folders"
                  :key="folder.id"
                  tabindex="0"
                  class="collapse w-96 border rounded-box border-base-300 mb-2"
                >
                  <div class="collapse-title text-xl font-medium flex justify-between">
                    <span v-text="folder.path"></span>
                    <span v-text="`${folder.schedule.label} ${folder.hour??''}`"></span>
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head,Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
  },
  props: {
    server: Object,
  },
};
</script>
