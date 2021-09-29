<template>
  <Head title="Server Detail" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Backups
          <span class="font-semibold text-indigo-700">{{ folder.path }}</span>
        </h2>
        <div>
          <Link class="btn" :href="`/servers/${folder.server.id}`"
            >Go Back</Link
          >
          <button class="btn btn-primary ml-1" :class="{'loading': backupRunning}" @click="runManualBackup()">
            Run Manual Backup
          </button>
        </div>
      </div>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
              <FolderDetail :folder="folder" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import FolderDetail from "./Components/Detail.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Link,
    FolderDetail,
  },
  data(){
      return {
          backupRunning: false,
      }
  },
  props: {
    folder: Object,
  },
  methods: {
    runManualBackup() {
        this.backupRunning=true
        this.$inertia.post(`/folders/${this.folder.id}/backups/run`, {}, {
            onFinish: ()=> this.backupRunning = false
        })
    },
  },
};
</script>
