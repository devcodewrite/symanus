<template>
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-10 max-h-96 overflow-y-auto">
  <div :key="checkitem.student.id" v-for="checkitem in checklist">
    <AttendanceCard
      @toggle-status="$emit('toggle-status',checkitem.attendance_id,checkitem)"
      @make-payment="$emit('make-payment', checkitem)"
      :checkitem="checkitem"
    />
  </div>
</div>
</template>

<script>
import AttendanceCard from './AttendanceCard'

export default {
  name: 'AttendanceCardList',
  props: {
    checklist: Array,
  },
  components: {
    AttendanceCard,
  },
  emits: ['make-payment', 'toggle-status'],
}
</script>
