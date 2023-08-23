import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import StudentView from "../views/students/StudentView.vue";
import CreateStudent from "../views/students/CreateStudent.vue";
import EditStudent from "../views/students/EditStudent.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/about",
      name: "about",
      component: () => import("../views/AboutView.vue"),
    },
    {
      path: "/students",
      name: "students",
      component: StudentView,
    },
    {
      path: "/students/create",
      name: "studentCreate",
      component: CreateStudent,
    },
    {
      path: "/students/:id/edit",
      name: "studentEdit",
      component: EditStudent,
    },
  ],
});

export default router;
