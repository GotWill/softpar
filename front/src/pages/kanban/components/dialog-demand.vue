<template>
    <q-dialog v-model="detailsDialog" transition-show="scale" transition-hide="scale">
        <q-card v-if="selectedDemand" style="width: 500px; max-width: 95vw; border-radius: 8px;">

            <q-card-section class="row items-center q-px-md q-py-sm border-b border-gray-100">
                <div class="text-weight-bold text-subtitle1 text-gray-900">{{ selectedDemand.title }}
                </div>
                <q-space />
                <q-btn icon="close" flat round dense v-close-popup color="grey-7" size="sm" />
            </q-card-section>

            <q-card-section class="q-pa-md">
                <div class="grid grid-cols-2 gap-x-4 gap-y-3">

                    <div class="info-block">
                        <span class="label">Cliente</span>
                        <span class="value">{{ selectedDemand?.client_name }}</span>
                    </div>

                    <div class="info-block">
                        <span class="label">Status</span>
                        <q-badge :label="selectedDemand.status" class="status-badge" />
                    </div>

                    <div class="info-block">
                        <span class="label">Prioridade</span>
                        <q-badge :label="selectedDemand.priority" color="teal-8" class="priority-badge" />
                    </div>

                    <div class="info-block">
                        <span class="label">Setor</span>
                        <span class="value">{{ selectedDemand.sector }}</span>
                    </div>

                    <div class="info-block">
                        <span class="label">Cobrada</span>
                        <span class="value">{{ selectedDemand.customer_charged ? 'Sim' : 'Não' }}</span>
                    </div>

                    <div class="info-block">
                        <span class="label">Responsável</span>
                        <span class="value">{{ selectedDemand.responsible }}</span>
                    </div>

                    <div class="info-block col-span-2">
                        <span class="label">Quem deve testar</span>
                        <span class="value">{{ selectedDemand.who_should_test }}</span>
                    </div>

                    <div class="info-block col-span-2">
                        <span class="label">Descrição Detalhada</span>
                        <span class="value text-gray-600">{{ selectedDemand.description }}</span>
                    </div>

                    <div class="info-block col-span-2">
                        <span class="label">Anexos</span>
                        <span class="value text-blue-600 cursor-pointer hover:underline">{{
                            selectedDemand.midia }}</span>
                    </div>

                </div>

                <q-separator class="q-my-md" />

                <div class="row q-col-gutter-md">
                    <div class="col-6">
                        <div class="label">Tempo Estimado</div>
                        <div class="text-h5 text-weight-bolder text-gray-900">{{ selectedDemand.estimated_time }}h</div>
                    </div>
                    <div class="col-6">
                        <div class="label">Tempo Gasto</div>
                        <div class="text-h5 text-weight-bolder text-gray-900">{{ selectedDemand.time_spent }}h</div>
                    </div>
                </div>
            </q-card-section>

        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
import type { Demand } from 'src/types/demand';


const detailsDialog = defineModel<boolean>({ required: true, default: false });
defineProps<{
    selectedDemand: Demand | null
}>();

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