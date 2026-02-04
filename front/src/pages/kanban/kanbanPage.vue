<template>
    <div class="p-6">
        <header class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Board de Operações</h2>
            <p class="text-gray-500">Gerencie o status das demandas arrastando os cards</p>
        </header>

        <div class="flex gap-4 overflow-x-auto pb-6 custom-scrollbar">

            <DemandSkeleton v-if="isLoading" />

            <div v-else v-for="column in board" :key="column.id"
                class="flex-shrink-0 w-[300px] bg-[#f8f9fa] rounded-xl border border-gray-200 flex flex-col">

                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-700 text-sm">{{ column.name }}</span>
                        <q-badge rounded color="blue-1" text-color="blue-7" :label="column.demands?.length" />
                    </div>
                    <q-btn flat round dense icon="more_horiz" size="sm" color="grey-6" />
                </div>

                <draggable @change="(evt) => onMove(evt, column.name)" item-key="id" v-model="column.demands"
                    group="demands" class="p-3 flex-grow overflow-y-auto min-h-[150px]" :animation="200"
                    ghost-class="ghost-card">
                    <div v-for="(demand, index) in column.demands" :key="index" class="mb-3">
                        <q-card flat
                            class="border-l-4 border-l-[#026fd7] border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow cursor-grab">

                            <div class="flex justify-between items-start mb-2">
                                <div class="font-bold text-gray-900 text-md">{{ demand.responsible }}</div>

                                <q-btn icon="visibility" size="2" @click="viewDemand(demand)"
                                    class="p-0 border-none before:shadow-none hover:bg-transparent min-h-0" />
                            </div>

                            <div class="text-xs text-gray-500 mb-3">{{ demand.priority }}</div>

                            <q-badge :label="demand.midia" color="teal-7" class="px-2 py-1 text-[10px] mb-3" />

                            <div class="space-y-1 pt-2 border-t border-gray-100">
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-gray-400">Estimado:</span>
                                    <span class="text-gray-700 font-medium">{{ demand.estimated_time }}</span>
                                </div>
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-gray-400">Gasto:</span>
                                    <span class="text-gray-700 font-medium">{{ demand.time_spent }}</span>
                                </div>
                            </div>
                        </q-card>
                    </div>
                </draggable>

                <DialogDemand v-model="detailsDialog" :selected-demand="selectedDemand" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useQuery, useQueryClient } from '@tanstack/vue-query';
import { demandService } from 'src/services/demand-service';
import type { Demand } from 'src/types/demand';
import type { DraggableEvent } from 'src/types/draggable';
import { ref, watch } from 'vue'
import { VueDraggableNext as draggable } from 'vue-draggable-next'
import confetti from 'canvas-confetti';

import DemandSkeleton from './components/demand-skeleton.vue';
import DialogDemand from './components/dialog-demand.vue';


const detailsDialog = ref(false)
const selectedDemand = ref<Demand | null>(null)

function viewDemand(demand: Demand) {
    detailsDialog.value = true
    selectedDemand.value = demand
}

const { data: demands, isLoading } = useQuery({
    queryKey: ['demands'],
    queryFn: async () => {
        const data = await demandService.demands();
        return data as Demand[];
    },

})

interface KanbanColumn {
    id: number;
    name: string;
    status: string;
    demands: Demand[];
}

const board = ref<KanbanColumn[]>([]);

const statusMapping: KanbanColumn[] = [
    { id: 1, name: 'Backlog', status: 'Backlog', demands: [] },
    { id: 2, name: 'Autorização', status: 'Backlog', demands: [] },
    { id: 3, name: 'Fila', status: 'Fila', demands: [] },
    { id: 4, name: 'Em desenvolvimento', status: 'Em desenvolvimento', demands: [] },
    { id: 5, name: 'Teste', status: 'Teste', demands: [] },
    { id: 6, name: 'Deploy', status: 'Deploy', demands: [] },
    { id: 7, name: 'Concluído', status: 'Concluído', demands: [] }
];

watch(demands, (newDemands) => {
    if (newDemands && board.value.every(col => col.demands.length === 0)) {
        board.value = statusMapping.map(col => ({
            ...col,
            demands: newDemands.filter(d => d.status === col.name)
        }));
    }
}, { immediate: true });


const queryClient = useQueryClient()

const onMove = async (evt: DraggableEvent<Demand>, columnName: string) => {
    if (evt.added) {
        const demand = evt.added.element;

        if (columnName === 'Concluído') {
            triggerFireworks()
        }

        try {
            await demandService.updateStatus(demand.id, columnName)
            void queryClient.invalidateQueries({ queryKey: ['demands'] })
        } catch (error) {
            console.log(error)
            void queryClient.invalidateQueries({ queryKey: ['demands'] })

        }

    }
};


const triggerFireworks = () => {
    const duration = 3 * 1000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

    const randomInRange = (min: number, max: number) => Math.random() * (max - min) + min;

    const interval = setInterval(function () {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 50 * (timeLeft / duration);

        void confetti({
            ...defaults,
            particleCount,
            origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
        });
        void confetti({
            ...defaults,
            particleCount,
            origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
        });
    }, 250);
};
</script>

