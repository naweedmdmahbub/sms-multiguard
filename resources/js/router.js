import { createWebHistory, createRouter } from "vue-router";
// import Register from './components/Register/List.vue';
// import RegisterShow from './components/Register/Show.vue';
import UserCreate from './components/Users/Create.vue';
import UserList from './components/Users/List.vue';


import DepartmentList from './components/Departments/List.vue';
import StudentList from './components/Students/List.vue';
import SemesterList from './components/Semesters/List.vue';

import NotFoundPage from './components/NotFoundPage.vue';
import Dashboard from './components/Dashboard/index.vue';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
    },
    // {
    //     path: '/registers',
    //     name: 'registers',
    //     component: Register,
    // },
    // {
    //     path: '/registers/view/:id',
    //     name: 'RegisterShow',
    //     component: RegisterShow,
    // },

    {
        path: '/users',
        name: 'UserList',
        component: UserList
    },
    {
        path: '/users/create',
        name: 'UserCreate',
        component: UserCreate
    },
    {
        path: '/users/edit/:id',
        name: 'UserEdit',
        component: UserCreate
    },
    {
        path: '/users/view/:id',
        name: 'UserView',
        component: UserCreate
    },
    
    
    /** Department */
    {
        path: '/departments',
        name: 'DepartmentList',
        component: DepartmentList
    },
    /** Student */
    {
        path: '/students',
        name: 'StudentList',
        component: StudentList
    },
    /** Student */
    {
        path: '/semesters',
        name: 'SemesterList',
        component: SemesterList
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFoundPage
    },

    //   { path: '*', redirect: '/404' },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
