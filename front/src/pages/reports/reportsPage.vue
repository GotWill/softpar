<template>
    <div class="flex flex-col gap-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Relatórios Mensais</h2>
            <p class="text-gray-500 text-lg">Visualize o desempenho e demandas por cliente</p>
        </div>

        <div class="flex flex-wrap items-start gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <q-select outlined v-model="form.client_id" :options="clients || []" option-label="name" option-value="id"
                emit-value map-options label="Selecione o Cliente" dense bg-color="grey-1" class="w-full md:w-80"
                :loading="isPending" lazy-rules
                :rules="[val => (val !== null && val !== undefined) || 'O cliente é obrigatório']" />

            <q-btn icon="event" outline color="primary" label="Período" class="h-[40px]">
                <q-popup-proxy ref="dateProxy" transition-show="scale" transition-hide="scale">

                    <q-date v-model="form.month" mask="YYYY-MM" minimal default-view="Months" emit-immediately
                        @update:model-value="handleDateSelection" />

                </q-popup-proxy>
            </q-btn>
        </div>

        <SkeletronReport v-if="isPendigGetReports"/>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" v-if="demands">
            <q-card flat class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                v-for="card in summaryCards" :key="card.label">
                <div class="text-gray-500 text-sm font-medium">{{ card.label }}</div>
                <div class="text-3xl font-bold mt-2 text-gray-900">{{ card.value }}</div>
            </q-card>
        </div>


        <q-card flat class="border border-gray-200 rounded-lg overflow-hidden" v-if="demands">
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-700">Demandas do Período</h3>
            </div>
            <q-table flat :rows="demands || []" :columns="columns" row-key="name" hide-pagination binary-state-sort>
                <template v-slot:body-cell-status="props">
                    <q-td :props="props">
                        <q-badge :color="props.value === 'Backlog' ? 'blue-1 text-blue-8' : 'gray-2'" class="px-2 py-1">
                            {{ props.value }}
                        </q-badge>
                    </q-td>
                </template>
                <template v-slot:body-cell-priority="props">
                    <q-td :props="props">
                        <q-badge class="px-2 py-1" :color="priorityMap[props.value as Prority]?.color || 'grey-2'"
                            :text-color="priorityMap[props.value as Prority]?.textColor || 'grey-7'">
                            {{ props.value }}
                        </q-badge>
                    </q-td>
                </template>
                <template v-slot:body-cell-customer_charged="props">
                    <q-td :props="props">
                        <q-icon :name="props.value ? 'send' : 'schedule_send'"
                            :color="props.value ? 'indigo' : 'grey-4'" size="sm">
                            <q-tooltip>{{ props.value ? 'Cliente Notificado' : 'Aguardando Envio' }}</q-tooltip>
                        </q-icon>
                    </q-td>
                </template>
            </q-table>
        </q-card>

        <q-card flat class="border border-gray-200 rounded-lg p-4" v-if="demands">
            <h3 class="text-lg font-bold text-gray-700 mb-2">Feedback do Período</h3>
            <p class="text-sm text-gray-500 mb-4">Adicione observações ou feedback sobre o período</p>

            <q-input v-model="feedback" type="textarea" outlined
                placeholder="Ex: Cliente satisfeito com as entregas, houve atraso na demanda X devido a Y..."
                bg-color="white" rows="4" />
            <div class="mt-2 text-xs text-gray-400">
                Este campo é apenas para anotações locais e não será salvo automaticamente.
            </div>
        </q-card>
    </div>
</template>

<script setup lang="ts">
import { useMutation, useQuery } from '@tanstack/vue-query';
import { QPopupProxy } from 'quasar';
import { clientService } from 'src/services/client-service';
import { reportService } from 'src/services/report-service';
import type { Client } from 'src/types/client';
import type { Demand, Prority } from 'src/types/demand';
import { ref, computed, reactive, watch } from 'vue';

import SkeletronReport from './components/skeletron-report.vue';

const feedback = ref('');

const { data: clients, isPending } = useQuery({
    queryKey: ['clients'],
    queryFn: async () => {
        const data = await clientService.clients()
        return data as Client[]
    },
})


const initialFormState = reactive({
    client_id: undefined,
    month: new Date().toISOString().slice(0, 7)
})

const form = reactive({ ...initialFormState })

const demands = ref<Demand[]>()

const { mutate, data, isPending: isPendigGetReports } = useMutation({
    mutationFn: async (data: { client_id: number, month: string }) => {
        const response = await reportService.get(data)
        return response as Demand[]
    }
})

watch(form, () => {
    if (form.client_id && form.month) {
        mutate({ client_id: form.client_id, month: form.month })
    }
});

const demandsCharged = demands.value?.reduce((acc, item) => {
    return item.customer_charged ? acc + 1 : acc
}, 0) || 0

const estimatedTime = computed(() => {
    return demands.value?.reduce((acc, item) => acc + (item.estimated_time || 0), 0) || 0;
});

const timeSpend = computed(() => {
    return demands.value?.reduce((acc, item) => acc + (item.time_spent || 0), 0) || 0;
});


watch(data, (newDemand) => {
    demands.value = newDemand
}, { immediate: true })


const summaryCards = computed(() => [
    { label: 'Total de Demandas', value: demands.value?.length },
    { label: 'Demandas Cobradas', value: demandsCharged },
    { label: 'Tempo Estimado', value: `${estimatedTime.value}h` },
    { label: 'Tempo Gasto', value: `${timeSpend.value}h` },
]);

const columns = [
    { name: 'title', label: 'Título', field: 'title', align: 'left' as const },
    { name: 'status', label: 'Status', field: 'status', align: 'left' as const },
    { name: 'priority', label: 'Prioridade', field: 'priority', align: 'left' as const },
    { name: 'cobranda', label: 'Cobrada', field: 'customer_charged', align: 'left' as const },
    { name: 'estTime', label: 'Tempo Est.', field: 'estimated_time', align: 'left' as const },
    { name: 'spentTime', label: 'Tempo Gasto', field: 'time_spent', align: 'left' as const },
];


type ProrityStyle = {
    color: string;
    textColor: string;
}
const priorityMap: Record<Prority, ProrityStyle> = {
    'Baixa': { color: 'blue-1', textColor: 'blue-9', },
    'Média': { color: 'green-1', textColor: 'green-9' },
    'Alta': { color: 'orange-1', textColor: 'orange-9' },
    'Urgente': { color: 'red-1', textColor: 'red-9' }
} as const;

const dateProxy = ref<QPopupProxy | null>(null);

const handleDateSelection = () => {
    if (dateProxy.value) {
        dateProxy.value.hide();
    }
};




</script>

<style scoped>
F .q-table__card {
    box-shadow: none;
}
</style>