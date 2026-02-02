import type { RouteRecordRaw } from 'vue-router';
import LayoutMain from '../layouts/MainLayout.vue';
import Home from 'pages/home/indexPage.vue';
import Taks from 'pages/tasks/tasksPage.vue';
import Reports from 'pages/reports/reportsPage.vue';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: LayoutMain,
    children: [
      {
        path: '',
        component: Home,
      },
      {
        path: '/demandas',
        component: Taks,
      },
      {
        path: '/relatorios',
        component: Reports,
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
