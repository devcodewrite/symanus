<template>
  <button @click="onClick()" class="flex justify-center items-center w-20 md:w-24 slef-end h-full">
      <i :class="['fa fa-spinner text-3xl md:text-4xl fa-spin', (isLoading?'':'no-loading')]"></i>
     <i :class="['fa fa-check text-3xl md:text-4xl', (status==='present'?'checked':'not-checked'), (isLoading?'loading':'') ]"></i>
  </button>
</template>

<script>
export default {
  name: 'StatusButton',
  props: {
    status: {
      type: String,
      default: 'absent',
    },
    isLoading: Boolean,
  },
  methods: {
    onClick() {
      this.$emit('btn-click')
    },
  },
}
</script>

<style scoped>
 .no-loading{
    display: none;
  }

 i{
    color: darkgray;
  }
.fa-check.loading{
  display: none;
  }

  i.checked {
    color: greenyellow;
  }
</style>
