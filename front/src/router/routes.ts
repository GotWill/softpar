import type { RouteRecordRaw } from 'vue-router';
import LayoutMain from '../layouts/MainLayout.vue';
import Home from 'src/pages/home/indexPage.vue';
import Demands from 'src/pages/demands/demandasPage.vue';

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
        component: Demands,
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
