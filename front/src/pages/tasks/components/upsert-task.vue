<template>
    <q-dialog v-model="dialogModel" persistent transition-show="scale" transition-hide="scale">
        <q-card style="width: 700px; max-width: 95vw;" class="rounded-xl shadow-2xl">
            <q-form @submit.prevent="sendForm">

                <q-card-section class="bg-primary text-white flex justify-between items-center py-4">
                    <div>
                        <div class="text-h6 font-bold">Gerenciar Tarefa</div>
                        <div class="text-caption opacity-80">Preencha os detalhes do ticket.</div>
                    </div>
                    <q-btn icon="close" flat round dense @click="close" />
                </q-card-section>

                <q-card-section class="q-pa-lg">
                    <div class="row q-col-gutter-md">

                        <div class="col-12 col-sm-5">
                            <label class="text-weight-bold text-grey-8 text-xs uppercase">Cliente</label>
                            <q-select outlined v-model="form.cliente_id" :options="['Cliente A', 'Cliente B']"
                                label="Selecione o Cliente" dense bg-color="grey-1" class="mt-1" lazy-rules
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-7">
                            <label class="text-weight-bold text-grey-8 text-xs uppercase">Título da Tarefa</label>
                            <q-input outlined v-model="form.titulo" dense bg-color="grey-1" class="mt-1"
                                placeholder="Ex: Ajuste no relatório..." lazy-rules
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.prioridade" :options="prioridades" label="Prioridade" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.setor" :options="setores" label="Setor" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-4">
                            <q-select outlined v-model="form.status" :options="statusKanban" label="Status Kanban" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.responsavel" label="Responsável" dense bg-color="grey-1"
                                icon="person" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.quem_deve_testar" label="Quem deve testar?" dense
                                bg-color="grey-1" :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12">
                            <q-input outlined v-model="form.descricao_detalhada" label="Descrição Detalhada"
                                type="textarea" rows="3" bg-color="grey-1"
                                :rules="[val => val && val.length > 0 || 'campo é obrigatório']" />
                        </div>

                        <div class="col-12 col-sm-6">
                            <q-input outlined v-model="form.links_anexos" label="Links de Anexos/Mídias" dense
                                bg-color="grey-1" placeholder="http://..." />
                        </div>
                        <div class="col-12 col-sm-3 ">
                            <q-input outlined v-model="form.tempo_estimado" label="Est. (h)" mask="###:##" dense
                                bg-color="grey-1" />
                        </div>
                        <div class="col-12 col-sm-3">
                            <q-input outlined v-model="form.tempo_gasto" label="Gasto (h)" mask="###:##" dense
                                bg-color="grey-1" />
                        </div>

                        <div class="col-12 flex gap-6 bg-grey-1 q-pa-sm rounded-lg border border-dashed mt-5">
                            <q-checkbox v-model="form.cobrada_do_cliente" label="Cobrar do Cliente?" color="primary" />
                            <q-checkbox v-model="form.flag_retornou" label="Retornou?" color="orange-8" />
                        </div>

                    </div>
                </q-card-section>

                <q-card-actions align="right" class="q-pa-md bg-grey-2">
                    <q-btn flat label="Cancelar" color="grey-7" @click="close" />
                    <q-btn type="submit" unelevated label="Salvar Tarefa" color="primary"
                        class="px-8 rounded-lg font-bold" />
                </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">

import { computed, ref } from "vue"

function sendForm() { }

const form = ref({
    cliente_id: '',
    titulo: '',
    prioridade: '',
    setor: '',
    status: '',
    responsavel: '',
    quem_deve_testar: '',
    descricao_detalhada: '',
    links_anexos: '',
    tempo_estimado: 0,
    tempo_gasto: 0,
    cobrada_do_cliente: false,
    flag_retornou: false


})

const prioridades = ['Baixa', 'Média', 'Alta', 'Urgente']
const setores = ['Financeiro', 'Comercial', 'Desenvolvimento', 'Suporte', 'RH']
const statusKanban = ['Backlog', 'Em Desenvolvimento', 'Testes', 'Concluído']

const emit = defineEmits(['update:is-open'])


const props = defineProps<{
    isOpen: boolean,
    close: () => void
}>()

const dialogModel = computed({
    get: () => props.isOpen,
    set: (value) => emit('update:is-open', value)
})


</script>