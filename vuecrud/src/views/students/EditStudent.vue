<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Add student</h3>
      </div>
      <ul
        class="alert alert-warning"
        v-if="Object.keys(this.errorList).length > 0"
      >
        <li
          class="mb-0 ms-3"
          v-for="(error, index) in this.errorList"
          :key="index"
        >
          {{ error[0] }}
        </li>
      </ul>
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input
            type="text"
            class="form-control"
            v-model="model.student.name"
          />
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email </label>
          <input
            type="email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            v-model="model.student.email"
          />
          <div id="emailHelp" class="form-text">
            We'll never share your email with anyone else.
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Course</label>
          <input
            type="text"
            class="form-control"
            v-model="model.student.course"
          />
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input
            type="text"
            class="form-control"
            v-model="model.student.phone"
          />
        </div>
        <div class="mb-3">
          <button type="button" @click="updateStudent" class="btn btn-primary">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "studentEdit",
  data() {
    return {
      studentId: "",
      errorList: "",
      model: {
        student: {
          name: "",
          course: "",
          email: "",
          phone: "",
        },
      },
    };
  },
  mounted() {
    // console.log(this.$route.params.id);
    this.studentId = this.$route.params.id;
    this.getStudentData(this.$route.params.id);
  },
  methods: {
    getStudentData(studentId) {
      var myThis = this;

      axios
        .get(`http://localhost:8000/api/students/${this.studentId}/edit`)
        .then((res) => {
          console.log(res.data.student);
          this.model.student = res.data.student;
        })
        .catch((error) => {
          if (error.response) {
            if (error.response.status === 422) {
              myThis.errorList = error.response.data.errors;
            }
            if (error.response.status === 404) {
              alert(error.response.data.message);
            }
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Lỗi", error.message);
          }
          console.log(error.config);
        });
    },
    updateStudent() {
      var myThis = this;
      axios
        .put("http://localhost:8000/api/students/", this.model.student)
        .then((res) => {
          console.log("data ", res.data);
          alert(res.data.message);

          this.model.student = {
            name: "",
            course: "",
            email: "",
            phone: "",
          };
        })
        .catch(function (error) {
          if (error.response) {
            if (error.response.status === 422) {
              myThis.errorList = error.response.data.errors;
            }
          } else if (error.request) {
            console.log(error.request);
          } else {
            console.log("Lỗi", error.message);
          }
          console.log(error.config);
        });
    },
  },
};
</script>
