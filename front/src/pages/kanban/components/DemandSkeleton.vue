<template>
    <div class="flex gap-5">
        <q-card v-for="n in 7" flat :key="n"
            class="border-l-4 border-l-gray-300 border border-gray-200 rounded-lg p-4 bg-white mb-3 flex-shrink-0 w-[300px]">

            <div class="flex justify-between items-start mb-2">
                <q-skeleton type="text" width="60%" height="24px" class="bg-gray-100" />
                <q-skeleton type="QBtn" size="sm" class="bg-gray-100" />
            </div>

            <div class="mb-3">
                <q-skeleton type="text" width="30%" class="bg-gray-50" />
            </div>

            <q-skeleton type="rect" width="50px" height="20px" class="rounded-md bg-teal-1" />

            <div class="space-y-1 pt-4 border-t border-gray-50 mt-2">
                <div class="flex justify-between">
                    <q-skeleton type="text" width="20%" />
                    <q-skeleton type="text" width="15%" />
                </div>
                <div class="flex justify-between">
                    <q-skeleton type="text" width="20%" />
                    <q-skeleton type="text" width="15%" />
                </div>
            </div>
        </q-card>
    </div>
</template>
