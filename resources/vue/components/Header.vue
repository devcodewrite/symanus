<template>
  <div class="w-full p-2 bg-white flex flex-row justify-between  items-center gap-3 mb-3">
    <button @click="$emit('submit')" :disabled="approved" class="px-2 py-1 text-sm rounded-md shadow-md bg-blue-600 disabled:bg-slate-200 text-white uppercase item-start">Sumbit for Approval</button>
    <div class="flex flex-row  gap-3 justify-between">
      <div class="font-semibold item-end">Toggle All</div>
    <input @click="$emit('toggle-check-all')" type="checkbox" name="all" id="toggle-all" class="h-8 w-8 item-end" :checked="isChecked">
    </div>
  </div>
</template>

<script>

export default {
  name: 'Header',
  props:{
    isChecked: Boolean,
    approved: Boolean,
  },
  emits: ['toggle-check-all', 'submit']
}
</script>
