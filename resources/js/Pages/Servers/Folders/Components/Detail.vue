<template>
  <div class="mt-4 overflow-x-auto">
    <table class="table w-full">
      <thead>
        <tr>
          <th>Filename</th>
          <th>Size</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="backup in folder.backups" :key="backup.id" class="hover">
          <td v-text="backup.path ?? 'NO FILE'"></td>
          <td v-text="sizeInMb(backup.size)"></td>
          <td>
            <span
              v-if="backup.successful"
              class="px-1 py-1 rounded text-white text-xs bg-green-600 shadow"
              >SUCCESSFUL</span
            >
            <span
              v-else
              class="px-1 py-1 rounded text-white text-xs bg-red-600 shadow"
              >ERROR</span
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
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
