<template>
    <div class="flex flex-col gap-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Relatórios Mensais</h2>
            <p class="text-gray-500 text-lg">Visualize o desempenho e demandas por cliente</p>
        </div>

        <div class="flex flex-wrap items-start gap-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <q-select outlined v-model="selectedClient" :options="clientOptions" label="Selecione o Cliente" dense
                bg-color="white" class="w-full md:w-80" />

            <q-btn icon="event" outline color="primary" label="Período" class="h-[40px]">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-date v-model="date" mask="YYYY-MM" minimal emit-immediately>
                        <div class="row items-center justify-end q-gutter-sm">
                            <q-btn label="Fechar" color="primary" flat v-close-popup />
                        </div>
                    </q-date>
                </q-popup-proxy>
            </q-btn>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <q-card flat class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow"
                v-for="card in summaryCards" :key="card.label">
                <div class="text-gray-500 text-sm font-medium">{{ card.label }}</div>
                <div class="text-3xl font-bold mt-2 text-gray-900">{{ card.value }}</div>
            </q-card>
        </div>

        <q-card flat class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-700">Demandas do Período</h3>
            </div>
            <q-table flat :rows="rows" :columns="columns" row-key="name" hide-pagination binary-state-sort>
                <template v-slot:body-cell-status="props">
                    <q-td :props="props">
                        <q-badge :color="props.value === 'Backlog' ? 'blue-1 text-blue-8' : 'gray-2'" class="px-2 py-1">
                            {{ props.value }}
                        </q-badge>
                    </q-td>
                </template>
                <template v-slot:body-cell-priority="props">
                    <q-td :props="props">
                        <q-badge label="Média" class="px-2 py-1"
                            :color="priorityMap[props.value as Prority]?.color || 'grey-2'"
                            :text-color="priorityMap[props.value as Prority]?.textColor || 'grey-7'">
                            {{ props.value }}
                        </q-badge>
                    </q-td>
                </template>
                <template v-slot:body-cell-cobranda="props">
                    <q-td :props="props">
                        <q-chip size="sm" color="green-1" text-color="green-9" icon="check"
                            v-if="props.value">Sim</q-chip>
                    </q-td>
                </template>
            </q-table>
        </q-card>

        <q-card flat class="border border-gray-200 rounded-lg p-4">
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
import { ref, computed } from 'vue';

const selectedClient = ref('');
const clientOptions = ['Cliente A', 'Cliente B'];
const date = ref(new Date().toISOString().slice(0, 7));
const feedback = ref('');

const summaryCards = computed(() => [
    { label: 'Total de Demandas', value: '1' },
    { label: 'Demandas Cobradas', value: '1' },
    { label: 'Tempo Estimado', value: '0h' },
    { label: 'Tempo Gasto', value: '222h' },
]);

const columns = [
    { name: 'title', label: 'Título', field: 'title', align: 'left' as const },
    { name: 'status', label: 'Status', field: 'status', align: 'left' as const },
    { name: 'priority', label: 'Prioridade', field: 'priority', align: 'left' as const },
    { name: 'cobranda', label: 'Cobrada', field: 'cobranda', align: 'left' as const },
    { name: 'estTime', label: 'Tempo Est.', field: 'estTime', align: 'left' as const },
    { name: 'spentTime', label: 'Tempo Gasto', field: 'spentTime', align: 'left' as const },
];

const rows = [
    {
        title: 'Troca banner',
        status: 'Backlog',
        priority: 'Média',
        cobranda: true,
        estTime: '0h',
        spentTime: '222h'
    }
];


type ProrityStyle = {
    color: string;
    textColor: string;
}
type Prority = 'Baixa' | 'Média' | 'Alta' | 'Urgente'
const priorityMap: Record<Prority, ProrityStyle> = {
    'Baixa': { color: 'blue-1', textColor: 'blue-9', },
    'Média': { color: 'green-1', textColor: 'green-9' },
    'Alta': { color: 'orange-1', textColor: 'orange-9' },
    'Urgente': { color: 'red-1', textColor: 'red-9' }
} as const;
</script>

<style scoped>
.q-table__card {
    box-shadow: none;
}
</style>