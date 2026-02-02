<template>
  <div class="flex flex-col gap-5">
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-h4 font-bold text-gray-800">Clientes</h2>
        <p class="text-xl">Gerencie seus clientes e informações de contato
        </p>
      </div>
      <q-btn icon="person_add" padding="10px 15px" class="rounded-md" label="Novo cliente" color="primary"
        @click="openNewClient" />
      <UpsertClient :is-open="alert" :close-modal="closeModal" />
    </div>


    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 w-full">

      <div class="text-left mb-8">
        <h3 class="text-lg font-bold text-gray-900">Lista de Clientes</h3>
      </div>

      <div v-if="!isUsersEmpty" class="flex flex-col items-center justify-center py-10">

        <div class="text-gray-500 mb-4">
          <q-icon name="group" size="64px" class="opacity-80" />
        </div>

        <div class="text-center">
          <p class="text-gray-600 text-base font-medium">
            Nenhum cliente cadastrado ainda.
          </p>
          <p class="text-gray-400 text-sm mt-1">
            Clique em "Novo Cliente" para começar.
          </p>
        </div>

      </div>


      <q-table :rows="rows" :columns="columns" row-key="id" flat bordered class="rounded-xl shadow-sm" v-else>

        <template v-slot:body-cell-notifications="props">
          <q-td :props="props">
            <div class="flex justify-center gap-2">

              <q-badge :color="props.row.warningEmail ? 'blue-1' : 'grey-2'"
                :text-color="props.row.warningEmail ? 'blue-9' : 'grey-5'" class="q-pa-xs px-2 rounded-md text-base">
                Email
              </q-badge>

              <q-badge :color="props.row.warningWhats ? 'green-1' : 'grey-2'"
                :text-color="props.row.warningWhats ? 'green-9' : 'grey-5'" class="q-pa-xs px-2 rounded-md text-base">
                whatsapp
              </q-badge>

            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-actions="props">
          <q-td :props="props">
            <div class="flex justify-end gap-2">

              <div class="border rounded-md hover:bg-blue-50">
                <q-btn flat dense icon="edit" @click="handleEdit(props.row)">
                  <q-tooltip>Editar registro</q-tooltip>
                </q-btn>
              </div>

              <div class="border rounded-md hover:bg-red-50">
                <q-btn flat dense icon="delete">
                  <q-tooltip>Excluir registro</q-tooltip>
                </q-btn>
              </div>

            </div>
          </q-td>
        </template>

        <template v-slot:body-cell-name="props">
          <q-td :props="props">
            <div class="font-bold text-primary">{{ props.value }}</div>
          </q-td>
        </template>
      </q-table>

      <UpsertClient v-model:is-open="alert" :user="selectedUser" :close-modal="closeModal" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { User } from 'src/types/user';
import UpsertClient from './components/upsert-client.vue';

const alert = ref(false)
const selectedUser = ref<User | null>(null)

const handleEdit = (user: User) => {
  selectedUser.value = { ...user }
  alert.value = true
}


const openNewClient = () => {
  selectedUser.value = null
  alert.value = true
}

function closeModal() {
  alert.value = false
}

const isUsersEmpty = true

const rows = ref([
  {
    id: 1,
    name: 'ola',
    email: 'teste',
    phone: '11965239222',
    observation: 'oi, tudo bem?',
    warningEmail: true,
    warningWhats: true
  },
  {
    id: 2,
    name: 'ola',
    email: 'teste',
    phone: '119620905559',
    observation: 'eeeeee',
    warningEmail: false,
    warningWhats: true


  }
])

const columns = [
  { id: 1, name: 'name', label: 'Nome', field: 'name', align: 'left' as const },
  { id: 2, name: 'email', label: 'E-mail', field: 'email', align: 'left' as const },
  { id: 3, name: 'phone', label: 'Telefone', field: 'phone', align: 'left' as const },
  { id: 4, name: 'observation', label: 'Observação', field: 'observation', align: 'left' as const },
  { id: 5, name: 'notifications', label: 'Notificações', field: 'id', align: 'center' as const },
  { id: 7, name: 'actions', label: 'Ações', field: 'actions', align: 'right' as const }
]

</script>
