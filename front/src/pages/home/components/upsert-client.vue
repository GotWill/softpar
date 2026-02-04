<template>
    <q-dialog v-model="dialogModel" persistent transition-show="scale" transition-hide="scale">
        <q-card style="width: 550px; max-width: 95vw;" class="rounded-xl shadow-2xl">

            <q-form @submit.prevent="upsertClient">

                <q-card-section class="bg-primary text-white flex justify-between items-center py-4">
                    <div>
                        <div class="text-h6 font-bold">{{ modalTitle }}</div>
                        <div class="text-caption opacity-80">{{ modalDescription }}</div>
                    </div>
                    <q-btn icon="close" flat round dense @click="closeModal" />
                </q-card-section>

                <q-card-section class="q-pa-lg">
                    <div class="space-y-5">

                        <div>
                            <label
                                class="text-weight-bold text-grey-8 text-xs uppercase tracking-wider">Identificação</label>
                            <q-input outlined v-model="form.name" label="Nome Completo" class="mt-2" bg-color="grey-1"
                                lazy-rules :rules="[val => val && val.length > 0 || 'O nome é obrigatório']">
                                <template v-slot:prepend>
                                    <q-icon name="person" color="primary" />
                                </template>
                            </q-input>
                        </div>

                        <div class="row q-col-gutter-md">
                            <div class="col-12 col-sm-6">
                                <q-input outlined v-model="form.email" label="E-mail" type="email" bg-color="grey-1"
                                    lazy-rules :rules="[val => val && val.length > 0 || 'O email é obrigatório']">
                                    <template v-slot:prepend>
                                        <q-icon name="mail" color="primary" />
                                    </template>
                                </q-input>
                            </div>
                            <div class="col-12 col-sm-6">
                                <q-input outlined v-model="form.whatsapp" label="WhatsApp" mask="(##) #####-####"
                                    bg-color="grey-1" lazy-rules
                                    :rules="[val => val && val.length > 0 || 'O telefone é obrigatório']">
                                    <template v-slot:prepend>
                                        <q-icon name="chat" color="green-6" />
                                    </template>
                                </q-input>
                            </div>
                        </div>

                        <div>
                            <q-input outlined v-model="form.observation" label="Observações Adicionais" type="textarea"
                                rows="3" bg-color="grey-1" />
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-3 text-blue-900 font-medium">
                                <q-icon name="notifications_active" size="20px" />
                                <span>Preferências de Alerta</span>
                            </div>
                            <div class="flex flex-wrap gap-x-6 gap-y-2">
                                <q-checkbox v-model="form.warning_email" label="E-mail" color="primary" dense />
                                <q-checkbox v-model="form.warning_whatsapp" label="WhatsApp" color="green-7" dense />
                            </div>
                        </div>
                    </div>
                </q-card-section>

                <q-card-actions align="right" class="q-pa-md bg-grey-1">
                    <q-btn flat label="Descartar" color="grey-7" class="px-4 rounded-lg" @click="closeModal" />
                    <q-btn type="submit" unelevated color="primary" :loading="isPending" :label="textButton"
                        class="px-6 rounded-lg font-bold" />

                </q-card-actions>

            </q-form>
        </q-card>
    </q-dialog>
</template>


<script setup lang="ts">
import type { Client } from 'src/types/client';
import { computed, reactive, watch } from 'vue'
import { clientService } from 'src/services/client-service';
import { useMutation, useQueryClient } from '@tanstack/vue-query';
import { useQuasar } from 'quasar'
import axios, { type AxiosError } from 'axios';

const props = defineProps<{
    user?: Client | null,
    isOpen: boolean;
    closeModal: () => void
}>()

const emit = defineEmits(['update:is-open', 'saved'])

const dialogModel = computed({
    get: () => props.isOpen,
    set: (value) => emit('update:is-open', value)
})

const initialFormState: Client = {
    id: undefined,
    name: '',
    email: '',
    whatsapp: '',
    observation: '',
    warning_email: false,
    warning_whatsapp: false
}

const form = reactive({ ...initialFormState })


const isEditing = computed(() => !!props.user?.id)

const modalTitle = computed(() =>
    isEditing.value ? `Editando ${props.user?.name}` : 'Informações de Contato'
)

const modalDescription = computed(() =>
    isEditing.value ? 'Altere os dados abaixo para manter o cadastro atualizado.' : 'Preencha os campos abaixo para o cadastro.'
)

const textButton = computed(() => (
    isEditing.value ? 'Atualizar' : 'Salvar Registro'
))



watch(() => props.user, (newUser) => {
    if (newUser) {
        Object.assign(form, newUser)
    } else {
        Object.assign(form, initialFormState)
    }
}, { immediate: true })

const queryClient = useQueryClient();
const q = useQuasar()


const { mutate, isPending } = useMutation({
    mutationFn: async (data: Client) => {
        if (data.id) {
            await clientService.update(data.id, data)
            return
        }
        await clientService.create_client(data)
    }
})

interface ApiErrorResponse {
    message: string;
    errors?: Record<string, string[]>;
}

function upsertClient() {
    mutate(form, {
        onSuccess: () => {
            q.notify({
                type: 'positive',
                message: form.id ? 'Cliente atualizado' : 'Cliente cadastrado',
                position: 'top'
            })
            void queryClient.invalidateQueries({ queryKey: ['clients'] });
            props.closeModal()
            emit('saved')
        },
        onError: (error) => {
            if (axios.isAxiosError(error)) {
                const serverError = error as AxiosError<ApiErrorResponse>;
                const message = serverError.response?.data?.message === 'The email has already been taken.' ? 'E-mail já registrado.' : 'Erro ao processar a requisição'
                q.notify({ type: 'negative', message, position: 'top' });
            } else {
                q.notify({ type: 'negative', message: 'Erro desconhecido' });
            }
        }
    })
}
</script>