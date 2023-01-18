<template>
  <div v-if="checklist.length > 0" class="bg-gray-100 p-2 flex flex-col">
    <Header
      @toggle-check-all="toggleCheckAll"
      :isChecked="checkAll"
      :approved="approved"
      @submit="submit"
    />
    <div>
      <AttendanceCardList
        :checklist="checklist"
        @toggle-status="toggleStatus"
        @make-payment="makePayment"
      />
    </div>
    <Footer />
  </div>
  <p v-if="checklist.length === 0" class="text-black-600 font-semibold">
    Initializing app...
  </p>
</template>
<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import AttendanceCardList from "./AttendanceCardList.vue";

export default {
  name: "AttendanceApp",
  components: {
    Header,
    Footer,
    AttendanceCardList,
  },
  data() {
    return {
      checklist: [],
      checkAll: false,
      approved: false,
    };
  },
  methods: {
    async makePayment(item) {
      Swal.fire({
        title: `Make Adavance Payment`,
        html: `<p>Student: ${item.student.firstname} ${item.student.surname}</p>`+
          '<input id="amount" name="amount" placeholder="Enter Amount" class="mb-2 h-10 px-1 w-full border">' +
          '<select id="fee-type" name="fee_type_id" class="w-full"></select>',
        preConfirm: function () {
          return new Promise(function (resolve) {
            resolve({amount:$("#amount").val(), fee_type_id:$("#fee-type").val()});
          });
        },
        willOpen: function () {
          $("#swal-input1").focus();
          $.ajax({ 
              url: "/api/select2/fee-types",
              dataType: "json",
              data: {api_token : $('meta[name="api-token"]').attr("content") },
              success: function(d, s){
                if(!d) return Swal.fire({ icon: "success", text: "Couldn't load fee types!"});
                 d.results.forEach((item)=>{
                    $('#fee-type').append($(`<option value="${item.id}">`).text(item.text));
                 });
              }
          });
        },
        showCancelButton: true,
        confirmButtonText: "Pay",
      })
        .then((result) => {
          if (!result.isConfirmed) return null;
          console.log(result);
          
          return fetch(`../api/json/student-advance-payment`, {
            method: "PUT",
            headers: {
              "Content-type": "application/json",
            },
            body: JSON.stringify({
              ...result.value,
              attendance: item.attendance,
              ...item.student,
              api_token: $('meta[name="api-token"]').attr("content"),
            }),
          })
            .then((response) => {
              response.json().then((result) => {
                if (
                  typeof result.status !== "boolean" ||
                  typeof result.message !== "string"
                ) {
                  Swal.fire({
                    icon: "error",
                    text: "Malformed data response! Please try agian.",
                  });
                  return;
                }
                if (result.status === true) {
                  this.checklist = this.checklist.map((checkitem) =>
                    checkitem.student_id === item.student_id
                      ? {
                          ...checkitem,
                          advance: result.data.amount,
                        }
                      : checkitem
                  );

                  Swal.fire({
                    icon: "success",
                    text: result.message,
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    text: result.message,
                  });
                }
              });
            })
            .catch((error) => {
              Swal.showValidationMessage(`Request failed: ${error}`);
            });
        })
        .catch((err) => {
          if (err) {
            Swal.fire(
              "Ops!",
              "Data couldn't be processed! Please try again!",
              "error"
            );
          } else {
            Swal.fire.stopLoading();
            Swal.fire.close();
          }
        });
    },
    async submit() {
      Swal.fire({
        title: "Are you sure ?",
        text: "You wouldn't be able to make any changes afterwards.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes! sumbit",
      }).then((result) => {
        if (!result.isConfirmed) return;
        const id = $("#vue-attendance-marking").data("attendance-id");
        const res = fetch(`../attendances/${id}`, {
          method: "PUT",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            status: "submitted",
            _token: $('meta[name="csrf-token"]').attr("content"),
          }),
        });
        res.then((res) => {
          res.json().then((result) => {
            if (
              typeof result.status !== "boolean" ||
              typeof result.message !== "string"
            ) {
              Swal.fire({
                icon: "error",
                text: "Malformed data response! Please try agian.",
              });
              return;
            }
            if (result.status === true) {
              this.checklist = this.fetchChecklist();
              Swal.fire({
                icon: "success",
                text: "Attendance submitted successfully!",
              });
              setTimeout(() => {
                 location.reload();
              }, 500);
            } else {
              Swal.fire({
                icon: "error",
                text: result.message,
              });
            }
          });
        });
      });
    },
    async toggleCheckAll() {
      Swal.fire({
        title: "Loading...",
        html: "Please wait...",
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });
      const id = $("#vue-attendance-marking").data("attendance-id");
      this.checkAll = !this.checkAll;
      const res = await fetch(
        `../api/json/attendance-related-students?attendance_id=${id}`,
        {
          method: "PUT",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            check_all: this.checkAll,
            api_token: $('meta[name="api-token"]').attr("content"),
          }),
        }
      );
      const qdata = await res.json();
      this.checklist = qdata.data;
      Swal.close();
    },
    async fetchChecklist() {
      const id = $("#vue-attendance-marking").data("attendance-id");
      const api_token = $('meta[name="api-token"]').attr("content");

      const res = await fetch(
        `../api/json/attendance-related-students?attendance_id=${id}&api_token=${api_token}`,
        {
          headers: {
            "Content-Type": "application/json",
            "X-API-TOKEN": $('meta[name="api-token"]').attr("content"),
          },
        }
      );
      const data = await res.json();

      if (data.length > 0)
        this.approved = data[0].attendance.status !== "draft";

      let isCheck = true;
      data.forEach((item) => {
        if (item.status === "absent") {
          isCheck = false;
          return;
        }
      });
      this.checkAll = isCheck;

      return data;
    },
    async getStudentAdvance(checkitem) {
      const res = await fetch(`../api/json/student-balance`, {
        method: "PUT",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify({
          data: {
            student: checkitem.student,
            attendance: checkitem.attendance,
          },
          api_token: $('meta[name="api-token"]').attr("content"),
        }),
      });
      const data = await res.json();
      return data;
    },
    async toggleStatus(id, item) {
      const res = await fetch(
        `../api/json/attendance-related-students?attendance_id=${id}`,
        {
          method: "PUT",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({
            data: item,
            api_token: $('meta[name="api-token"]').attr("content"),
          }),
        }
      );

      const qdata = await res.json();
      if (this.checkAll && item.status === "absent") {
        this.checkAll = false;
      }

      this.checklist = this.checklist.map((checkitem) =>
        checkitem.student_id === item.student_id
          ? {
              ...checkitem,
              status: qdata.data.status,
              updated_at: qdata.data.updated_at,
            }
          : checkitem
      );
    },
  },
  async created() {
    this.checklist = await this.fetchChecklist();
  },
};
</script>
 