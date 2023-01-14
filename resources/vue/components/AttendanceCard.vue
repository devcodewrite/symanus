<template>
  <button @click="onDblClick()" class="w-full p-1 rounded-lg flex flex-row justify-between hover:bg-blue-200 cursor-pointer bg-white shadow-md h-24">
      <img :src="[checkitem.student.avatar?checkitem.student.avatar:'../img/no-image.png']" alt="Student Photo" class="w-24 h-full" />
    <div class="p-1 flex flex-col text-sm justify-between">
      <div class="flex flex-col items-start">
        <span class="font-semibold">{{ checkitem.student.firstname }} {{ checkitem.student.surname }}</span>
        <span class="text-xs">{{ checkitem.student.studentid }} </span>
      </div>
      <span class="text-[10px] text-gray-600 place-self-end flex self-end content-start w-full">{{ checkitem.updated_at }} </span>
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