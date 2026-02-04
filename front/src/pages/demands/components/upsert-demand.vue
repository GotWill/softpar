<template>
    <q-dialog v-model="dialogModel" persistent transition-show="scale" transition-hide="scale">
        <q-card style="width: 700px; max-width: 95vw;" class="rounded-xl shadow-2xl">
            <q-form @submit.prevent="sendForm">

                <q-card-section class="bg-primary text-white flex justify-between items-center py-4">
                    <div>
                        <div class="text-h6 font-bold">Gerenciar Tarefa</div>
                        <div class="text-caption opacity-80">Preencha os detalhes do ticket.</div>
                    </div>
                    <q-btn icon="close" flat round dense @click="close" :disable="!clients" />
                </q-card-section>

                <q-card-section class="q-pa-lg">
                    <div class="row q-col-gutter-md">
                        <div class="col-12 col-sm-5">
                            <label class="text-weight-bold text-grey-8 text-xs uppercase">Cliente</label>
                            <q-select outlined v-model="form.client_id" :options="clients || []" option-label="name"
                                option-value="id" emit-value map-options label="Selecione o Cliente" dense
                                bg-color="grey-1" class="mt-1" :loading="isPending" lazy-rules
                                :rules="[val => (val !== null && val !== undefined) || 'O cliente é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-7">
                            <label class="text-weight-bold text-grey-8 text-xs uppercase">Título da Tarefa</label>
                            <q-input outlined v-model="form.title" dense bg-color="grey-1" class="mt-1"
                                placeholder="Ex: Ajuste no relatório..." lazy-rules
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.priority" :options="prioridades" label="Prioridade" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.sector" :options="setores" label="Setor" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.status" :options="statusKanban" label="Status Kanban" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.responsible" label="Responsável" dense bg-color="grey-1"
                                icon="person" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.who_should_test" label="Quem deve testar?" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12">
                            <q-input outlined v-model="form.description" label="Descrição Detalhada" type="textarea"
                                rows="3" bg-color="grey-1"
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.midia" label="Links de Anexos/Mídias" dense
                                bg-color="grey-1" placeholder="http://..."
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-3 ">
                            <q-input outlined v-model="form.estimated_time" label="Est. (h)" dense bg-color="grey-1" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <q-input outlined v-model="form.time_spent" label="Gasto (h)" dense bg-color="grey-1" />
                        </div>

                        <div class="col-12 flex gap-6 bg-grey-1 q-pa-sm rounded-lg border border-dashed mt-5">
                            <q-checkbox v-model="form.customer_charged" label="Cobrar do Cliente?" color="primary" />
                            <q-checkbox v-model="form.return" label="Retornou?" color="orange-8" />
                        </div>

                    </div>
                </q-card-section>

                <q-card-actions align="right" class="q-pa-md bg-grey-2">
                    <q-btn flat label="Cancelar" color="grey-7" @click="close" />
                    <q-btn type="submit" unelevated label="Salvar Tarefa" color="primary"
                        class="px-8 rounded-lg font-bold" :loading="isPendingUpsert" />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">

import { useMutation, useQueryClient } from "@tanstack/vue-query"
import { demandService } from "src/services/demand-service"
import type { UpsertDemand, Demand } from "src/types/demand"
import { useQuery } from "@tanstack/vue-query"
import { clientService } from "src/services/client-service"
import type { Client } from "src/types/client"
import { computed, reactive, watch } from "vue"
import { useQuasar } from 'quasar'

const props = defineProps<{
    isOpen: boolean,
    close: () => void,
    demand?: Demand | null;
}>()

const { data: clients, isPending } = useQuery({
    queryKey: ['clients'],
    queryFn: async () => {
        const data = await clientService.clients()
        return data as Client[]
    },
})


const initialFormState: UpsertDemand = reactive({
    client_id: null,
    title: '',
    priority: 'Alta',
    sector: '',
    responsible: '',
    who_should_test: '',
    description: '',
    midia: '',
    customer_charged: false,
    estimated_time: 0,
    time_spent: 0,
    status: 'Backlog',
    return: false,
})


const form = reactive({ ...initialFormState })

const prioridades = ['Baixa', 'Média', 'Alta', 'Urgente']
const setores = ['Financeiro', 'Comercial', 'Desenvolvimento', 'Suporte', 'RH']
const statusKanban = ['Backlog', 'Autorização', 'Fila', 'Em desenvolvimento', 'Teste', 'Deploy', 'Concluído']

const emit = defineEmits(['update:is-open'])



watch(() => props.demand, (demand) => {
    if (demand) {
        form.client_id = Number(props.demand?.client_id);
        Object.assign(form, demand)
    } else {
        Object.assign(form, initialFormState)
    }
}, { immediate: true })

const dialogModel = computed({
    get: () => props.isOpen,
    set: (value) => emit('update:is-open', value)
})



const { mutate, isPending: isPendingUpsert } = useMutation({
    mutationFn: async (demand: UpsertDemand) => {
        if (demand.client_id && demand.id) {
            return await demandService.update(demand?.id, demand)
        }
        await demandService.create(demand)
    }
})

const queryClient = useQueryClient()
const q = useQuasar()

function sendForm() {
    mutate(form, {
        onSuccess: () => {
            q.notify({
                type: 'positive',
                message: form.client_id ? 'Demanda atualizada' : 'Demanda cadastrada',
                position: 'top'
            })
            void queryClient.invalidateQueries({ queryKey: ['demands'] })
            props.close()
        },
        onError: () => {

        }
    })
}

</script>