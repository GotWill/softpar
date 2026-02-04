<template>
    <q-markup-table flat bordered class="rounded-xl shadow-sm overflow-hidden" v-if="isLoading">
        <thead>
            <tr>
                <th class="text-left">Título</th>
                <th class="text-left">Prioridade</th>
                <th class="text-left">Responsável</th>
                <th class="text-center">Status</th>
                <th class="text-center">Tempos (Est/Gasto)</th>
                <th class="text-center">Cobrado</th>
                <th class="text-right">Ações</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="n in 5" :key="n">
                <td class="text-left">
                    <q-skeleton type="text" width="180px" class="q-mb-xs" />
                </td>

                <td class="text-left">
                    <q-skeleton type="rect" width="70px" height="20px" class="rounded-md" />
                </td>

                <td class="text-left">
                    <q-skeleton type="text" width="120px" />
                </td>

                <td class="text-center">
                    <div class="row justify-center">
                        <q-skeleton type="rect" width="100px" height="20px" class="rounded-md" />
                    </div>
                </td>

                <td class="text-center">
                    <div class="row justify-center q-gutter-x-xs">
                        <q-skeleton type="text" width="30px" />
                    </div>
                </td>

                <td class="text-center">
                    <div class="row justify-center">
                        <q-skeleton type="rect" size="24px" />
                    </div>
                </td>

                <td class="text-right">
                    <div class="row justify-end q-gutter-x-sm">
                        <q-skeleton type="QBtn" size="28px" />
                        <q-skeleton type="QBtn" size="28px" />
                    </div>
                </td>
            </tr>
        </tbody>
    </q-markup-table>

    <q-table v-if="!isLoading && demands" :rows="demands" :columns="columns" row-key="id" flat bordered
        class="rounded-xl shadow-sm">
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
                                    <q-btn flat label="Não, manter" color="grey-9"
                                        class="text-weight-bold q-px-md flex-grow-1" v-close-popup no-caps
                                        style="min-width: 140px" />
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


        <template v-slot:body-cell-customer_charged="props">
            <q-td :props="props">
                <q-icon :name="props.value ? 'send' : 'schedule_send'" :color="props.value ? 'indigo' : 'grey-4'"
                    size="sm">
                    <q-tooltip>{{ props.value ? 'Cliente Notificado' : 'Aguardando Envio' }}</q-tooltip>
                </q-icon>
            </q-td>
        </template>

        <template v-slot:body-cell-return="props">
            <q-td :props="props">
                <q-badge class="q-pa-sm" :color="props.value ? 'red-12' : 'green-12'" :label="props.value ? 'Sim' : 'Não'"/> 
            </q-td>
        </template>

        <template v-slot:body-cell-name="props">
            <q-td :props="props">
                <div class="font-bold text-primary">{{ props.value }}</div>
            </q-td>
        </template>
    </q-table>

    <upsertDemand v-model:is-open="isOpen" :close="closeModal" :demand="selectedDemand" />
</template>


<script setup lang="ts">
import { useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import { demandService } from 'src/services/demand-service';
import type { Demand, Prority, Status } from 'src/types/demand';
import upsertDemand from './upsert-demand.vue';
import { ref } from 'vue';

const isOpen = ref(false)
const selectedDemand = ref<Demand | null>(null)
const confirmDialog = ref(false)

const { data: demands, isLoading } = useQuery({
    queryKey: ['demands'],
    queryFn: async () => {
        const data = await demandService.demands();
        return data;
    }

})

function handleEdit(demand: Demand) {
    selectedDemand.value = demand
    isOpen.value = true
}

function closeModal() {
    isOpen.value = false
}

const columns = [
    { id: 1, name: 'title', label: 'Titulo', field: 'title', align: 'left' as const },
    { id: 2, name: 'client_name', label: 'Cliente', field: 'client_name', align: 'left' as const },
    { id: 3, name: 'priority', label: 'Prioridade', field: 'priority', align: 'left' as const },
    { id: 4, name: 'sector', label: 'Setor', field: 'sector', align: 'left' as const },
    { id: 5, name: 'responsible', label: 'Responsavel', field: 'responsible', align: 'center' as const },
    { id: 6, name: 'who_should_test', label: 'Quem deve estar', field: 'who_should_test', align: 'center' as const },
    { id: 8, name: 'midia', label: 'Midia', field: 'midia', align: 'center' as const },
    { id: 9, name: 'customer_charged', label: 'Cliente cobrado', field: 'customer_charged', align: 'center' as const },
    { id: 10, name: 'estimated_time', label: 'Tempo est:', field: 'estimated_time', align: 'center' as const },
    { id: 11, name: 'time_spent', label: 'Tempo gasto', field: 'time_spent', align: 'center' as const },
    { id: 12, name: 'status', label: 'Status', field: 'status', align: 'center' as const },
    { id: 13, name: 'return', label: 'Retornou', field: 'return', align: 'center' as const },
    { id: 14, name: 'actions', label: 'Ações', field: 'actions', align: 'right' as const }
]



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

const { mutate, isPending } = useMutation({
    mutationFn: async (id: number) => {
        await demandService.delete(id)
    }
})

const queryClient = useQueryClient();


function handleDelete(id: number) {

    mutate(id, {
        onSuccess: () => {
            void queryClient.invalidateQueries({ queryKey: ['demands'] });
            confirmDialog.value = false
        },
    })
}

</script>