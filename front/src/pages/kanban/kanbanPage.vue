<template>
    <div class="p-6">
        <header class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Board de Operações</h2>
            <p class="text-gray-500">Gerencie o status das demandas arrastando os cards</p>
        </header>

        <div class="flex gap-4 overflow-x-auto pb-6 custom-scrollbar">

            <div v-for="column in board" :key="column.id"
                class="flex-shrink-0 w-[300px] bg-[#f8f9fa] rounded-xl border border-gray-200 flex flex-col">

                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-700 text-sm">{{ column.name }}</span>
                        <q-badge rounded color="blue-1" text-color="blue-7" :label="column.tasks.length" />
                    </div>
                    <q-btn flat round dense icon="more_horiz" size="sm" color="grey-6" />
                </div>

                <draggable v-model="column.tasks" group="tasks" class="p-3 flex-grow overflow-y-auto min-h-[150px]"
                    :animation="200" ghost-class="ghost-card">
                    <div v-for="task in column.tasks" :key="task.id" class="mb-3">
                        <q-card flat
                            class="border-l-4 border-l-[#026fd7] border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow cursor-grab">

                            <div class="flex justify-between items-start mb-2">
                                <div class="font-bold text-gray-900 text-md">{{ task.title }}</div>

                                <q-btn icon="visibility" size="2" @click="isOpen = true"
                                    class="p-0 border-none before:shadow-none hover:bg-transparent min-h-0" />
                            </div>

                            <div class="text-xs text-gray-500 mb-3">{{ task.description }}</div>

                            <q-badge :label="task.priority" color="teal-7" class="px-2 py-1 text-[10px] mb-3" />

                            <div class="space-y-1 pt-2 border-t border-gray-100">
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-gray-400">Estimado:</span>
                                    <span class="text-gray-700 font-medium">{{ task.estTime }}</span>
                                </div>
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-gray-400">Gasto:</span>
                                    <span class="text-gray-700 font-medium">{{ task.spentTime }}</span>
                                </div>
                            </div>


                            <q-dialog v-model="isOpen" transition-show="scale" transition-hide="scale">
                                <q-card style="width: 500px; max-width: 95vw; border-radius: 8px;">

                                    <q-card-section class="row items-center q-px-md q-py-sm border-b border-gray-100">
                                        <div class="text-weight-bold text-subtitle1 text-gray-900">eee</div>
                                        <q-space />
                                        <q-btn icon="close" flat round dense v-close-popup color="grey-7" size="sm" />
                                    </q-card-section>

                                    <q-card-section class="q-pa-md">
                                        <div class="grid grid-cols-2 gap-x-4 gap-y-3">

                                            <div class="info-block">
                                                <span class="label">Cliente</span>
                                                <span class="value">eee</span>
                                            </div>

                                            <div class="info-block">
                                                <span class="label">Status</span>
                                                <q-badge label="Autorização" class="status-badge" />
                                            </div>

                                            <div class="info-block">
                                                <span class="label">Prioridade</span>
                                                <q-badge label="Média" color="teal-8" class="priority-badge" />
                                            </div>

                                            <div class="info-block">
                                                <span class="label">Setor</span>
                                                <span class="value">Financeiro</span>
                                            </div>

                                            <div class="info-block">
                                                <span class="label">Cobrada</span>
                                                <span class="value">Sim</span>
                                            </div>

                                            <div class="info-block">
                                                <span class="label">Responsável</span>
                                                <span class="value">eee</span>
                                            </div>

                                            <div class="info-block col-span-2">
                                                <span class="label">Quem deve testar</span>
                                                <span class="value">eee</span>
                                            </div>

                                            <div class="info-block col-span-2">
                                                <span class="label">Descrição Detalhada</span>
                                                <span class="value text-gray-600">eee</span>
                                            </div>

                                            <div class="info-block col-span-2">
                                                <span class="label">Anexos</span>
                                                <span
                                                    class="value text-blue-600 cursor-pointer hover:underline">eee</span>
                                            </div>

                                        </div>

                                        <q-separator class="q-my-md" />

                                        <div class="row q-col-gutter-md">
                                            <div class="col-6">
                                                <div class="label">Tempo Estimado</div>
                                                <div class="text-h5 text-weight-bolder text-gray-900">0h</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="label">Tempo Gasto</div>
                                                <div class="text-h5 text-weight-bolder text-gray-900">222h</div>
                                            </div>
                                        </div>
                                    </q-card-section>

                                </q-card>
                            </q-dialog>
                        </q-card>
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { VueDraggableNext as draggable } from 'vue-draggable-next'

const isOpen = ref(false)

const board = ref([
    {
        id: 1,
        name: 'Autorização',
        tasks: [
            {
                id: 101,
                title: 'Troca de banner',
                description: 'lorem',
                priority: 'Média',
                estTime: '0h',
                spentTime: '222h'
            },
        ]
    },
    { id: 2, name: 'Fila', tasks: [] },
    { id: 3, name: 'Em desenvolvimento', tasks: [] },
    { id: 4, name: 'Teste', tasks: [] },
    { id: 5, name: 'Deploy', tasks: [] },
    { id: 6, name: 'Concluído', tasks: [] }
])
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cfd8dc;
    border-radius: 10px;
}

.ghost-card {
    opacity: 0.5;
    background: #eceff1;
    border: 2px dashed #b0bec5;
}

.cursor-grab {
    cursor: grab;
}

.cursor-grab:active {
    cursor: grabbing;
}


.info-block {
    display: flex;
    flex-direction: column;
    border-bottom: 1px solid #f3f4f6;
    padding-bottom: 4px;
}

.label {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9ca3af;
    font-weight: 600;
    margin-bottom: 2px;
}

.value {
    font-size: 14px;
    color: #1f2937;
    font-weight: 500;
}

.status-badge {
    background-color: #f3f4f6;
    color: #374151;
    font-size: 11px;
    padding: 2px 8px;
    width: fit-content;
}

.priority-badge {
    font-size: 10px;
    padding: 2px 6px;
    width: fit-content;
}

.col-span-2:last-of-type {
    border-bottom: none;
}
</style>
