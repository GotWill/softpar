<template>
    <q-table :rows="rows" :columns="columns" row-key="id" flat bordered class="rounded-xl shadow-sm">
        <template v-slot:body-cell-notifications="props">
            <q-td :props="props">
                <div class="flex justify-center gap-2">

                    <q-badge :color="props.row.warningEmail ? 'blue-1' : 'grey-2'"
                        :text-color="props.row.warningEmail ? 'blue-9' : 'grey-5'"
                        class="q-pa-xs px-2 rounded-md text-base">
                        Email
                    </q-badge>

                    <q-badge :color="props.row.warningWhats ? 'green-1' : 'grey-2'"
                        :text-color="props.row.warningWhats ? 'green-9' : 'grey-5'"
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
                        <q-btn flat dense icon="edit">
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

        <template v-slot:body-cell-priority="props">
            <q-td :props="props">
                <q-badge :color="priorityMap[props.value as Prority]?.color || 'grey-2'"
                    :text-color="priorityMap[props.value as Prority]?.textColor || 'grey-7'"
                    class="q-pa-sm rounded-md font-bold">
                    <q-icon :name="priorityMap[props.value as Prority]?.icon || 'help'" size="14px" class="q-mr-xs" />
                    {{ props.value }}
                </q-badge>
            </q-td>
        </template>

        <template v-slot:body-cell-status="props">
            <q-td :props="props">
                <q-badge v-if="statusMap[props.value as Status]" :color="statusMap[props.value as Status].color"
                    :text-color="statusMap[props.value as Status].textColor"
                    class="q-pa-sm rounded-md font-bold shadow-sm" style="border: 1px solid currentColor">
                    <q-icon :name="statusMap[props.value as Status].icon" size="16px" class="q-mr-xs" />
                    {{ props.value }}
                </q-badge>
            </q-td>
        </template>

        <template v-slot:body-cell-name="props">
            <q-td :props="props">
                <div class="font-bold text-primary">{{ props.value }}</div>
            </q-td>
        </template>
    </q-table>
</template>


<script setup lang="ts">
import { ref } from 'vue';

const rows = ref([
    {
        id: 1,
        title: 'Troca banner',
        client: 'Willian poreira',
        priority: 'Média',
        sector: 'TI',
        status: 'Concluído',
        time: '10'
    },
])

const columns = [
    { id: 1, name: 'title', label: 'Titulo', field: 'title', align: 'left' as const },
    { id: 2, name: 'client', label: 'Cliente', field: 'client', align: 'left' as const },
    { id: 3, name: 'priority', label: 'Prioridade', field: 'priority', align: 'left' as const },
    { id: 4, name: 'sector', label: 'Setor', field: 'sector', align: 'left' as const },
    { id: 5, name: 'status', label: 'Status', field: 'status', align: 'center' as const },
    { id: 6, name: 'time', label: 'Tempo', field: 'time', align: 'center' as const },
    { id: 7, name: 'actions', label: 'Ações', field: 'actions', align: 'right' as const }
]

type Prority = 'Baixa' | 'Média' | 'Alta' | 'Urgente'
type Status = 'Backlog' | 'Autorização' | 'Fila' | 'Em desenvolvimento' | 'Teste' | 'Deploy' | 'Concluído';

type ProrityStyle = {
    color: string;
    textColor: string;
    icon: string;
}
const priorityMap: Record<Prority, ProrityStyle> = {
    'Baixa': { color: 'blue-1', textColor: 'blue-9', icon: 'arrow_downward' },
    'Média': { color: 'green-1', textColor: 'green-9', icon: 'remove' },
    'Alta': { color: 'orange-1', textColor: 'orange-9', icon: 'arrow_upward' },
    'Urgente': { color: 'red-1', textColor: 'red-9', icon: 'priority_high' }
} as const;

type StatusStyle = {
    color: string;
    textColor: string;
    icon: string;
}

const statusMap: Record<Status, StatusStyle> = {
    'Backlog': {
        color: 'grey-2',
        textColor: 'grey-9',
        icon: 'inventory_2'
    },
    'Autorização': {
        color: 'purple-1',
        textColor: 'purple-9',
        icon: 'verified_user'
    },
    'Fila': {
        color: 'cyan-1',
        textColor: 'cyan-9',
        icon: 'format_list_numbered'
    },
    'Em desenvolvimento': {
        color: 'blue-1',
        textColor: 'blue-9',
        icon: 'terminal'
    },
    'Teste': {
        color: 'orange-1',
        textColor: 'orange-9',
        icon: 'bug_report'
    },
    'Deploy': {
        color: 'deep-orange-1',
        textColor: 'deep-orange-9',
        icon: 'rocket_launch'
    },
    'Concluído': {
        color: 'green-2',
        textColor: 'green-10',
        icon: 'check_circle'
    }
} as const;

</script>