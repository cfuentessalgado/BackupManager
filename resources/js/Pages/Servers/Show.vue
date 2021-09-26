<template>
  <Head title="Server Detail" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Servers</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <button type="button" @click="modalOpen=true" class="btn btn-outline">Add Folder</button>

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
                    <span v-text="`${folder.schedule.label} ${folder.hour}`"></span>
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
    <div :class="modalOpen || Object.keys(errors).length > 0 ? 'modal modal-open' : 'modal' ">
      <div class="modal-box">
        <div class="form-control">
          <label class="label">
            <span class="label-text">Folder Path</span>
          </label>
          <input
            type="text"
            v-model="path"
            placeholder="/folder/path/to/backup"
            :class="
              errors.path
                ? 'input input-bordered input-error'
                : 'input input-bordered'
            "
          />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Add Ignore Pattern</span>
          </label>
          <input
            type="text"
            class="input input-bordered"
            placeholder="Ex: .env*"
            v-model="ignoredPattern"
          />
        </div>
        <button class="btn btn-sm btn-primary mt-4" @click="addIgnorePattern()">
          Add Ignore Pattern
        </button>
        <p class="text-gray-500 text-xs mt-2" v-text="ignoredPatternsText"></p>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Add Backup Pattern</span>
          </label>
          <input
            type="text"
            class="input input-bordered"
            placeholder="Ex: important_info/*"
            v-model="backupPattern"
          />
        </div>
        <button class="btn btn-sm btn-primary mt-4" @click="addBackupPattern()">
          Add Backup Pattern
        </button>
        <p class="text-gray-500 text-xs mt-2" v-text="backupPatternsText"></p>
        <select
          class="select select-bordered w-full max-w-xs"
          v-model="selectedSchedule"
        >
          <option
            v-for="schedule in schedules"
            :key="schedule.id"
            v-text="schedule.description"
            :value="schedule.label"
          ></option>
        </select>
        <div
          v-if="selectedSchedule && selectedSchedule === 'dailyAt'"
          class="form-control"
        >
          <label class="label">
            <span class="label-text">Time</span>
          </label>
          <input type="time" class="input input-bordered" v-model="hour" />
        </div>
        <div class="modal-action">
          <button @click="submit()" class="btn btn-success">Add Folder</button>
          <button @click="cancel()" class="btn btn-error">Cancel</button>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
  },
  props: {
    server: Object,
    schedules: Array,
    errors: {
      type: Object,
    },
  },
  data() {
    return {
      path: null,
      ignoredPattern: null,
      ignoredPatterns: [],
      backupPattern: null,
      backupPatterns: [],
      selectedSchedule: null,
      hour: null,
      modalOpen: false,
    };
  },
  computed: {
    ignoredPatternsText() {
      if (this.ignoredPatterns.length === 0) {
        return "";
      }
      return `Patterns: ${this.ignoredPatterns.join(",")}`;
    },
    backupPatternsText() {
      if (this.backupPatterns.length === 0) {
        return "";
      }
      return `Patterns: ${this.backupPatterns.join(",")}`;
    },
  },
  methods: {
    submit() {
      const data = {
        path: this.path,
        ignored_patterns: this.ignoredPatterns,
        backup_patterns: this.backupPatterns,
        schedule: this.selectedSchedule,
        hour: this.hour,
      }

      this.$inertia.post(`/server/${this.server.id}/folders`, data)
      this.modalOpen = false
    },
    cancel() {
      this.modalOpen=false
      this.$inertia.reload({preserveState:false, replace:true})
    },
    addIgnorePattern() {
      if (!this.ignoredPattern) {
        return;
      }
      this.ignoredPatterns.push(this.ignoredPattern);
      this.ignoredPattern = null;
    },
    addBackupPattern() {
      if (!this.backupPattern) {
        return;
      }
      this.backupPatterns.push(this.backupPattern);
      this.backupPattern = null;
    },
  },
};
</script>
