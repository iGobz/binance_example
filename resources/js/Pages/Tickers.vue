<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { computed, onMounted, reactive } from 'vue';

const props = defineProps([
    'user_tickers'
])

const tickers = reactive([])

onMounted(() => {

    axios.get('https://api.binance.com/api/v3/ticker/24hr')
    .then(res => {
        for (const i in res.data) {
            if (res.data[i]['symbol'].endsWith('USDT')) {
                tickers.push(res.data[i]['symbol'])
            }
            if (tickers.length > 30) {
                break
            }
        }
    })
})

function toggle(t, e) {
    axios.post(route('ticker.toggle'), {
        ticker: t
    })
    .then(res => {
        console.log(res.data)
        if (res.data.status == 'added') {
            e.target.classList.add('bg-green-800')
        }
        if (res.data.status == 'removed') {
            e.target.classList.remove('bg-green-800')
        }
        e.target.blur()

    })
}
</script>

<template>
    <Head title="Tickers" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Binance Tickers
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 w-11/12">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg flex content-around justify-center flex-wrap">
                    <PrimaryButton v-for="ticker in tickers" :class="`mx-1 my-1 ${user_tickers.includes(ticker) ? 'bg-green-800' : ''}`" @click="toggle(ticker, $event)">{{ ticker }}</PrimaryButton>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
