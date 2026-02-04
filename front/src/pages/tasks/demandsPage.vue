<template>
    <div class="flex flex-col gap-5">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-h4 font-bold text-gray-800">Demandas</h2>
                <p class="text-xl">Gerencie todas as demandas e solicitações
                </p>
            </div>
            <q-btn icon="add_circle" padding="10px 15px" class="rounded-md" label="Nova demanda" color="primary"
                @click="openDialog = true" />
            <upsertDemand :is-open="openDialog" :close="closeModal" />
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 w-full">
            <div class="text-left mb-8">
                <h3 class="text-lg font-bold text-gray-900">Lista de Demandas
                </h3>
            </div>

            <div v-if="!isDemands" class="flex flex-col items-center justify-center py-10">

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

            <listDemand v-else />
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import upsertDemand from './components/upsert-demand.vue';
import listDemand from './components/list-demand.vue';

const openDialog = ref(false)

function closeModal() {
    openDialog.value = false
}

const isDemands = true
</script>