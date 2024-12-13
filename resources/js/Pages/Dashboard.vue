<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, onUnmounted, onUpdated, reactive } from 'vue';

const props = defineProps([
    'user_tickers'
])

const ws_data = reactive([])
const ws_connections = []

onMounted(() => {
    for(const i in props.user_tickers) {
        const socket = new WebSocket(`wss://stream.binance.com:443/ws/${props.user_tickers[i].toLowerCase()}@miniTicker`)
        socket.onopen = function (e) {
            console.log(`opened ${props.user_tickers[i]}`)
            ws_connections.push(socket)
        }
        socket.onmessage = function (e) {
            const data = JSON.parse(e.data)
            ws_data[props.user_tickers[i]] = parseFloat(data['c'])
        }
        socket.onerror = function (e) {
        }
        socket.onclose = function (e) {
            console.log(`closed ${props.user_tickers[i]}`)
            const index = ws_connections.indexOf(socket)
            if (index > -1) {
                ws_connections.splice(index, 1)
            }
        }
    }
})

onUnmounted(() => {
    for (const i in ws_connections) {
        ws_connections[i].close()
    }
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg w-1/2 m-auto"
                >
                    <div v-if="user_tickers.length" class="p-6">
                        <div v-for="user_ticker in user_tickers" class="flex justify-between">
                            <div >
                                {{ user_ticker }}
                            </div>
                            <div>
                                {{ ws_data[user_ticker] }}
                            </div>
                        </div>

                    </div>
                    <div class="p-6 text-gray-900" v-else>
                        You will see your selected tickers here
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
