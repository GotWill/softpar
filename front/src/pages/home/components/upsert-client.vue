<template>
    <q-dialog v-model="dialogModel" persistent transition-show="scale" transition-hide="scale">
        <q-card style="width: 550px; max-width: 95vw;" class="rounded-xl shadow-2xl">

            <q-form @submit.prevent="salvar">

                <q-card-section class="bg-primary text-white flex justify-between items-center py-4">
                    <div>
                        <div class="text-h6 font-bold">Informações de Contato</div>
                        <div class="text-caption opacity-80">Preencha os campos abaixo para o cadastro.</div>
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
                                <q-input outlined v-model="form.phone" label="WhatsApp" mask="(##) #####-####"
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
                                <q-checkbox v-model="form.warningEmail" label="E-mail" color="primary" dense />
                                <q-checkbox v-model="form.warningWhats" label="WhatsApp" color="green-7" dense />
                            </div>
                        </div>
                    </div>
                </q-card-section>

                <q-card-actions align="right" class="q-pa-md bg-grey-1">
                    <q-btn flat label="Descartar" color="grey-7" class="px-4 rounded-lg" @click="closeModal" />
                    <q-btn type="submit" unelevated label="Salvar Registro" color="primary"
                        class="px-6 rounded-lg font-bold" />
                </q-card-actions>

            </q-form>
        </q-card>
    </q-dialog>
</template>


<script setup lang="ts">
import { computed, reactive, watch } from 'vue'

const props = defineProps<{
    user?: {
        name: string;
        email: string,
        phone: string,
        observation: string,
        warningEmail: boolean,
        warningWhats: boolean
    } | null,
    isOpen: boolean;
    closeModal: () => void
}>()

const emit = defineEmits(['update:is-open'])

const dialogModel = computed({
    get: () => props.isOpen,
    set: (value) => emit('update:is-open', value)
})

const initialFormState = {
    name: '',
    email: '',
    phone: '',
    observation: '',
    warningEmail: false,
    warningWhats: false
}

const form = reactive({ ...initialFormState })

watch(() => props.user, (newUser) => {
    if (newUser) {
        Object.assign(form, newUser)
    } else {
        Object.assign(form, initialFormState)
    }
}, { immediate: true })


const salvar = () => {
    console.log('Dados do formulário:', { ...form })
    emit('update:is-open', false) 
}
</script>