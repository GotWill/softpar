<template>
    <div class="q-gutter-y-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <q-card v-for="i in 4" :key="i" flat class="border border-gray-200 rounded-lg p-4">
                <q-skeleton type="text" width="40%" class="text-sm" />
                <q-skeleton type="text" width="60%" height="45px" class="mt-2" />
            </q-card>
        </div>

        <q-card flat class="border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                <q-skeleton type="rect" width="150px" height="24px" />
            </div>

            <div class="p-4">
                <div class="row q-col-gutter-md q-mb-sm">
                    <div v-for="col in 5" :key="col" class="col">
                        <q-skeleton type="text" />
                    </div>
                </div>
                <div v-for="row in 5" :key="row" class="row q-col-gutter-md q-mb-sm">
                    <div v-for="col in 5" :key="col" class="col">
                        <q-skeleton type="rect" height="20px" />
                    </div>
                </div>
            </div>
        </q-card>

        <q-card flat class="border border-gray-200 rounded-lg p-4">
            <q-skeleton type="text" width="200px" height="28px" class="mb-2" />
            <q-skeleton type="text" width="300px" class="mb-4" />
            <q-skeleton type="rect" height="120px" class="rounded-lg" />
            <q-skeleton type="text" width="400px" class="mt-2" />
        </q-card>
    </div>
</template>