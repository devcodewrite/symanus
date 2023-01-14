import {createApp} from 'vue';
import AttendanceApp from '../vue/components/AttendanceApp.vue';

var app = createApp({
   components:{
    AttendanceApp,
   }
  })
  .mount('#vue-attendance-marking');