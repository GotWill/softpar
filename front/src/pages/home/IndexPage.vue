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

      <q-markup-table flat bordered class="rounded-xl shadow-sm" v-if="isLoading">
        <thead>
          <tr>
            <th class="text-left" style="width: 30%">Nome</th>
            <th class="text-left">E-mail</th>
            <th class="text-left">Telefone</th>
            <th class="text-left">Notificações</th>
            <th class="text-right">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="n in 5" :key="n">
            <td class="text-left">
              <q-skeleton type="text" width="150px" class="q-my-sm" />
            </td>
            <td class="text-left">
              <div class="row q-gutter-x-sm">
                <q-skeleton type="text" width="150px" />
              </div>
            </td>
            <td class="text-left">
              <div class="row q-gutter-x-sm">
                <q-skeleton type="text" width="150px" />
              </div>
            </td>
            <td class="text-left">
              <div class="row q-gutter-x-sm">
                <q-skeleton type="text" width="150px" />
              </div>
            </td>
            <td class="text-right">
              <div class="row justify-end q-gutter-x-sm">
                <q-skeleton type="QBtn" size="32px" />
                <q-skeleton type="QBtn" size="32px" />
              </div>
            </td>
          </tr>
        </tbody>
      </q-markup-table>

      <div v-if="!isLoading && clients.length === 0" class="flex flex-col items-center justify-center py-10">

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


      <div v-if="!isLoading && clients">
        <q-table :rows="clients" :columns="columns" row-key="id" flat bordered class="rounded-xl shadow-sm"
          v-if="clients.length > 0">

          <template v-slot:body-cell-notifications="props">
            <q-td :props="props">
              <div class="flex justify-start gap-2">

                <q-badge :color="props.row.warning_email ? 'blue-1' : 'grey-2'"
                  :text-color="props.row.warning_email ? 'blue-9' : 'grey-5'" class="q-pa-xs px-2 rounded-md text-base">
                  Email
                </q-badge>

                <q-badge :color="props.row.warning_whatsapp ? 'green-1' : 'grey-2'"
                  :text-color="props.row.warning_whatsapp ? 'green-9' : 'grey-5'"
                  class="q-pa-xs px-2 rounded-md text-base">
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
                  <q-btn flat dense icon="delete" @click="confirmDialog = true">
                    <q-tooltip>Excluir registro</q-tooltip>
                  </q-btn>
                  <q-dialog v-model="confirmDialog" persistent backdrop-filter="blur(4px)">
                    <q-card class="q-pa-sm" style="width: 450px; border-radius: 24px;">

                      <q-card-section class="column items-center q-pt-xl">
                        <div class="bg-red-1 q-pa-lg rounded-circle flex flex-center"
                          style="width: 80px; height: 80px; border-radius: 50%">
                          <q-icon name="delete_sweep" color="negative" size="42px" />
                        </div>

                        <div class="text-h5 text-weight-bold q-mt-lg text-dark">Excluir registro?</div>
                        <div class="text-body1 text-grey-7 text-center q-mt-sm q-px-md">
                          Você está prestes a remover este item. Esta ação <span
                            class="text-weight-bold text-negative">não pode ser desfeita</span>.
                        </div>
                      </q-card-section>

                      <q-card-actions align="center" class="q-pb-xl q-pt-lg q-px-xl">
                        <q-btn flat label="Não, manter" color="grey-9" class="text-weight-bold q-px-md flex-grow-1"
                          v-close-popup no-caps style="min-width: 140px" />
                        <q-btn unelevated label="Sim, excluir" color="negative"
                          class="q-px-lg rounded-borders text-weight-bold shadow-2 flex-grow-1" no-caps
                          @click="handleDelete(props.row.id)" :loading="isPending"
                          style="min-width: 140px; border-radius: 12px;" />
                      </q-card-actions>
                    </q-card>
                  </q-dialog>
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
      </div>

      <UpsertClient v-model:is-open="alert" :user="selectedUser" :close-modal="closeModal" />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Client } from 'src/types/client';
import { ref } from 'vue'
import UpsertClient from './components/upsert-client.vue';
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query'
import { clientService } from 'src/services/client-service';

const alert = ref(false)
const selectedUser = ref<Client | null>(null)

const confirmDialog = ref(false)


const { data: clients, isLoading } = useQuery({
  queryKey: ['clients'],
  queryFn: async () => await clientService.clients(),
});


const handleEdit = (user: Client) => {
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

const columns = [
  { id: 1, name: 'name', label: 'Nome', field: 'name', align: 'left' as const },
  { id: 2, name: 'email', label: 'E-mail', field: 'email', align: 'left' as const },
  { id: 3, name: 'whatsapp', label: 'Telefone', field: 'whatsapp', align: 'left' as const },
  { id: 4, name: 'notifications', label: 'Notificações', field: 'id', align: 'left' as const },
  { id: 5, name: 'actions', label: 'Ações', field: 'actions', align: 'right' as const }
]

const queryClient = useQueryClient();

const { mutate, isPending } = useMutation({
  mutationFn: async (id: number) => {
    await clientService.delete(id)
  }
})

function handleDelete(id: number) {

  mutate(id, {
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: ['clients'] });
      confirmDialog.value = false
    },

    onError: () => {
      console.log("d")
    }
  })
}


</script>
