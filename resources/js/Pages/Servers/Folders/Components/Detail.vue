<template>
  <div class="mt-4 overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>Filename</th>
          <th>Size</th>
          <th>Date</th>
          <th>Status</th>
          <td>Download</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="backup in folder.backups" :key="backup.id" class="hover">
          <td v-text="backup.path ?? 'NO FILE'"></td>
          <td v-text="sizeInMb(backup.size)"></td>
          <td v-text="backup.since"></td>
          <td>
            <span
              v-if="backup.successful && !backup.pending"
              class="px-1 py-1 rounded text-white text-xs bg-green-600 shadow"
              >SUCCESSFUL</span
            >
            <div v-if="backup.pending" class="flex items-center space-x-1">
              <span
                class="
                  px-1
                  py-1
                  rounded
                  text-white text-xs
                  bg-yellow-600
                  shadow
                "
                >PENDING
              </span>
              <span class="btn btn-outline btn-accent btn-square btn-xs" @click="checkBackupStatus(backup)">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                  />
                </svg>
              </span>
            </div>

            <span
              v-if="!backup.successful && !backup.pending"
              class="px-1 py-1 rounded text-white text-xs bg-red-600 shadow"
              >ERROR</span
            >
          </td>
          <td>
            <a
              :href="`/backups/${backup.id}/download`"
              class="btn btn-sm btn-square btn-outline btn-primary"
              download
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                className="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth="{2}"
                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"
                />
              </svg>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    Link,
  },
  props: {
    folder: Object,
  },
  methods: {
    sizeInMb(size) {
      return Math.floor(size / (1024 * 1024)) + " MB";
    },
    checkBackupStatus(backup) {
        this.$inertia.post(`/backups/${backup.id}/check`,)
    }
  },
};
</script>
