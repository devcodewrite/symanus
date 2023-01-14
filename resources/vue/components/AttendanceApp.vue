<template>
  <div class="bg-gray-100 p-2 flex flex-col">
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
</template>
<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import AttendanceCardList from "./AttendanceCardList.vue";
import { getTransitionRawChildren } from '@vue/runtime-core';

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
    async makePayment(checkitem) {
      const res = this.getStudentBalance(checkitem);
      res
        .then((res) => {
          if (!res.status)
            return Swal.fire({
              icon: "error",
              text: res.message,
            });
          Swal.fire({
            title: `Make Payment for ${checkitem.student.firstname} ${checkitem.student.surname}`,
            text: `Amount GHS ${Number.parseFloat(res.data).toFixed(2)}`,
            input: "number",
            inputAttributes: {
              placeholder: "Enter the amount",
              required: true,
            },
            inputValidator: (value) => {
              if (!value) {
                return "You need to put an amount";
              }
            },
            showCancelButton: true,
            confirmButtonText: "Pay",
          }).then((result) => {
            if (!result.isConfirmed) return null;
            return fetch(`../api/json/bill-payment-by-attendance`, {
              method: "PUT",
              headers: {
                "Content-type": "application/json",
              },
              body: JSON.stringify({
                amount: result.value,
                ...checkitem,
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
                    if (typeof result.input === "object") {
                    }
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
      console.log('submit');
      Swal.fire({
        title: "Are you sure ?",
        text: "You wouldn't be able to make any changes afterwards.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes! sumbit",
      }).then((result) => {
        if (!result.isConfirmed) return;
        const id = $("#vue-attendance-marking").data("attendance-id");
        const res = fetch(
          `../attendances/${id}`,
          {
            method: "PUT",
            headers: {
              "Content-type": "application/json",
            },
            body: JSON.stringify({
              status: "submitted",
              _token: $('meta[name="csrf-token"]').attr("content"),
            }),
          }
        );
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
    async getStudentBalance(checkitem) {
      const res = await fetch(`../api/json/student-balance`, {
        method: "PUT",
        headers: {
          "Content-type": "application/json",
        },
        body: JSON.stringify({
          data: checkitem,
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
      //console.log(qdata)
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
 