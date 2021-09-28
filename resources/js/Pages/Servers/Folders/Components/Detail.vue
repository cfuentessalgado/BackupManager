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
              v-if="backup.successful && backup.size > 0"
              class="px-1 py-1 rounded text-white text-xs bg-green-600 shadow"
              >SUCCESSFUL</span
            >
            <span
              v-else-if="backup.successful && backup.size < 0"
              class="px-1 py-1 rounded text-white text-xs bg-yellow-600 shadow"
              >PENDING</span
            >
            <span
              v-else
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
  },
};
</script>
