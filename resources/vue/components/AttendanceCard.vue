<template>
  <button @click="onDblClick()" class="w-full p-1 rounded-lg flex flex-row justify-between hover:bg-blue-200 cursor-pointer bg-white shadow-md h-24">
      <img :src="[checkitem.student.avatar?checkitem.student.avatar:'../img/no-image.png']" alt="Student Photo" class="w-24 h-full" />
    <div class="flex flex-col justify-between h-full w-full px-2">
      <div class="flex flex-col items-start content-start pt-1">
        <span class="font-semibold text-xs break-all">{{ checkitem.student.firstname }} {{ checkitem.student.surname }}</span>
        <span class="text-[9px] text-slate-600">{{ checkitem.student.studentid }} </span>
        <span class="text-xs text-green-600 mt-1">GHS {{ checkitem.balance }} </span>
      </div>
      <span class="text-[8px] text-gray-600 self-end flex items-start w-full">Last update: {{ checkitem.updated_at }} </span>
    </div>
    <StatusButton @click="onClick()" :isLoading="isLoading" :status="checkitem.status" />
  </button>
</template>

<script>
import StatusButton from "./StatusButton.vue";

export default {
  name: "AttendanceCard",
  components: {
    StatusButton,
  },
  data(){
    return {
      isLoading: false,
      doubleClicked: false,
    }
  },
  methods: {
    onClick(){
      this.isLoading = !this.isLoading
      this.checkitem.status = ['present','absent'][this.checkitem.status === 'present'?1:0]
      this.$emit('toggle-status')
    },
    onDblClick(){
      
      if (this.doubleClicked) {
           this.$emit('make-payment');
        }
        this.doubleClicked = true;
        setTimeout(() => {
            this.doubleClicked = false;
        }, 300);
    }
  },
  async updated(){
    this.isLoading = false;
  },
  props: {
    checkitem: Object,
  },
  emits: ['toggle-status', 'make-payment'],
};
</script>