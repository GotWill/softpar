<template>
  <q-layout>
    <div class="p-5 border border-b-gray-200 flex gap-10 items-center">
      <h1 class="leading-normal text-2xl font-bold">Sistema de Gestão</h1>
      <div class="flex gap-4">
        <q-btn v-for="(link, index) in links" :key="index" flat padding="10px 15px" class="rounded-md"
          :class="path === link.slug ? 'bg-primary text-white' : ''" :icon="link.icon" :label="link.label" no-caps
          @click="router.push(link.slug)" />
      </div>
    </div>
    <q-page-container class="p-5">
      <router-view />
    </q-page-container>
  </q-layout>

</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const links = [
  {
    id: 1,
    label: 'Clientes',
    slug: '/',
    icon: 'group_add'
  },
  {
    id: 2,
    label: 'Demandas',
    slug: '/demandas',
    icon: 'content_paste'
  },
  {
    id: 3,
    label: 'Kanbam',
    slug: '/kanbam',
    icon: 'view_kanban'
  },
  {
    id: 4,
    label: 'Relatorios',
    slug: '/relatorios',
    icon: 'analytics'
  },
]

const router = useRouter()
const path = computed(() => router.currentRoute.value.fullPath)
</script>
