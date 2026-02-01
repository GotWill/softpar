import type { RouteRecordRaw } from 'vue-router';
import LayoutMain from '../layouts/MainLayout.vue';
import Home from 'pages/IndexPage.vue';
const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: LayoutMain,
    children: [
      {
        path: '',
        component: Home,
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
