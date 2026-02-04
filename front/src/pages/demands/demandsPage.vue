<template>
    <div class="flex flex-col gap-5">

        <div class="flex justify-between items-center q-mb-lg" v-if="isPending">
            <div>
                <q-skeleton type="text" width="180px" height="48px" class="q-mb-sm" />
                <q-skeleton type="text" width="320px" height="24px" />
            </div>

            <div>
                <q-skeleton type="QBtn" width="150px" height="44px" class="rounded-md" />
            </div>
        </div>

        <div class="flex justify-between items-center" v-else>
            <div>
                <h2 class="text-h4 font-bold text-gray-800">Demandas</h2>
                <p class="text-gray-500">Gerencie todas as demandas e solicitações
                </p>
            </div>

            <q-btn icon="add_circle" padding="10px 15px" class="rounded-md" label="Nova demanda" color="primary"
                @click="openDialog = true" :disable="clients?.length === 0">
                <q-tooltip v-if="clients?.length === 0" class="text-body2">
                    Cadastre ao menos um cliente antes de criar demandas.
                </q-tooltip>
            </q-btn>
            <upsertDemand :is-open="openDialog" :close="closeModal" :clients="clients || []" :is-pending="isPending" />
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 w-full">
            <div class="text-left mb-8">
                <h3 class="text-lg font-bold text-gray-900">Lista de Demandas
                </h3>
            </div>

            <div v-if="demands?.length === 0" class="flex flex-col items-center justify-center py-10">

                <div class="text-gray-500 mb-4">
                    <q-icon name="content_paste" size="64px" class="opacity-80" />
                </div>

                <div class="text-center">
                    <p class="text-gray-600 text-base font-medium">
                        Nenhuma demanda cadastrada ainda.
                    </p>
                    <p class="text-gray-400 text-sm mt-1">
                        Clique em "Nova Demanda" para começar.
                    </p>
                </div>
            </div>

            <listDemand :demands="demands || []" :is-loading="isLoading" v-else />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import upsertDemand from './components/upsert-demand.vue';
import listDemand from './components/list-demand.vue';
import { useQuery } from '@tanstack/vue-query';
import { demandService } from 'src/services/demand-service';
import { clientService } from 'src/services/client-service';
import type { Client } from 'src/types/client';
import type { Demand } from 'src/types/demand';

const openDialog = ref(false)

function closeModal() {
    openDialog.value = false
}

const { data: demands, isLoading } = useQuery({
    queryKey: ['demands'],
    queryFn: async () => {
        const data = await demandService.demands();
        return data as Demand[];
    }
})

const { data: clients, isPending } = useQuery({
    queryKey: ['clients'],
    queryFn: async () => {
        const data = await clientService.clients()
        return data as Client[]
    },
})

</script>