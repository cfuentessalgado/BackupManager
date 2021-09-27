<template>
  <Head title="New Folder" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2>New Folder</h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="overflow-x-auto">
             <BreezeValidationErrors class="mb-4"/>
              <div class="form-control">
                <label class="label">
                  <span class="label-text">Folder Path</span>
                </label>
                <input
                  type="text"
                  v-model="path"
                  placeholder="/folder/path/to/backup"
                  class="input input-bordered"
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
              <button
                class="btn btn-sm btn-primary mt-4"
                @click="addIgnorePattern()"
              >
                Add Ignore Pattern
              </button>
              <p
                class="text-gray-500 text-xs mt-2"
                v-text="ignoredPatternsText"
              ></p>
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
              <button
                class="btn btn-sm btn-primary mt-4"
                @click="addBackupPattern()"
              >
                Add Backup Pattern
              </button>
              <p
                class="text-gray-500 text-xs mt-2"
                v-text="backupPatternsText"
              ></p>
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
                <input
                  type="time"
                  class="input input-bordered"
                  v-model="hour"
                />
              </div>
              <div class="form-control">
                <label for="max_backups" class="label"
                  ><span class="label-text">Max # of Backups</span></label
                >
                <input
                  type="number"
                  class="input input-bordered"
                  id="max_backups"
                  v-model="maxBackups"
                  min="1"
                  max="10"
                />
              </div>
              <div class="modal-action">
                <button @click="submit()" class="btn btn-success">
                  Add Folder
                </button>
                <Link :href="`/servers/${server.id}`" class="btn btn-error">Cancel</Link>
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
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeValidationErrors,
    Head,
    Link,
  },
  props: {
      server: Object,
      schedules: Array,
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
      maxBackups: 1,
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
        ignore_patterns: this.ignoredPatterns,
        backup_patterns: this.backupPatterns,
        schedule: this.selectedSchedule,
        hour: this.hour,
      }
      console.log(data)
      this.$inertia.post(`/servers/${this.server.id}/folders`, data)
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
