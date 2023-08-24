import { RouterLink } from 'vue-router';
<template>
  <main class="students">
    <div>
      <div class="card">
        <div class="card-header">
          <h3>
            Students
            <RouterLink to="students/create" class="btn btn-primary float-end"
              >Add student</RouterLink
            >
          </h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Course</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Created At</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody v-if="this.students.length > 0">
              <tr v-for="(student, index) in this.students" :key="index">
                <td>{{ student.id }}</td>
                <td>{{ student.name }}</td>
                <td>{{ student.course }}</td>
                <td>{{ student.email }}</td>
                <td>{{ student.phone }}</td>
                <td>{{ student.created_at }}</td>
                <td>
                  <RouterLink
                    :to="{ path: '/students/' + student.id + '/edit' }"
                    class="btn btn-info"
                  >
                    Edit
                  </RouterLink>
                  <button
                    type="button"
                    @click="deleteStudent(student.id)"
                    class="btn btn-danger mx-4"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <tr>
                <td colspan="7">Loading ...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import axios from "axios";
export default {
  name: "students",
  data() {
    return {
      students: [],
    };
  },
  mounted() {
    this.getStudents();
  },
  methods: {
    getStudents() {
      axios.get("http://localhost:8000/api/students").then((res) => {
        this.students = res.data.students;
        console.log(this.students);
      });
    },
    deleteStudent(studentId) {
      if (confirm("Are you sure you want to delete")) {
        axios
          .delete(`http://localhost:8000/api/students/${studentId}/delete`)
          .then((res) => {
            alert(res.data.message);
            this.getStudents();
          })
          .catch(function (error) {
            if (error.response) {
              if (error.response.status === 404) {
                alert(error.response.data.message);
              }
            }
          });
      }
    },
  },
};
</script>
