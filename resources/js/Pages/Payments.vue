<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps([
    'payments'
])

const form = useForm({
    amount: '0',
    currency: 'USDT'
})

function submit() {

    axios.post(route('payments.store'), form)
        .then(res => {
            const newPayment = {
                date: res.data.date,
                amount: res.data.amount,
                currency: res.data.currency
            }
            form.amount = '0'
            form.errors = []
            props.payments.push(newPayment)
        })
        .catch(res => form.errors = res.response.data.errors)
}

</script>

<template>
    <Head title="Payments" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Payments
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 w-2/3">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="table w-full" v-if="payments.length > 0">
                        <div class="flex p-4 justify-between">
                            <div>Date</div>
                            <div>Amount</div>
                            <div>Currency</div>
                        </div>

                        <div v-for="payment in payments" class="flex p-4 m-2 justify-between">
                            <div class="text-sm">{{ payment.date }}</div>
                            <div>{{ payment.amount }}</div>
                            <div>{{ payment.currency }}</div>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900" v-else>
                        Your payments list will be here
                    </div>
                    <form @submit.prevent="submit">
                        <div class="flex items-center justify-center">
                            <TextInput :class="form.errors.amount ? 'border-red-500' : ''" v-model="form.amount"/>
                            <div class="p-4">
                                <select name="currency" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="form.currency">
                                    <option value="USDT">USDT</option>
                                    <option value="USD">USD</option>
                                    <option value="RUB">RUB</option>
                                </select>
                            </div>
                            <PrimaryButton :disabled="form.processing">Pay</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
