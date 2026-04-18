<template>
    <form v-on:submit.prevent="getQuote" action="post">

        <div class="row">
            <div class="col-md-4">
                <label>Select Currency</label>

                <select v-on:change="onSelect()" v-model="order.currency">
                    <option value="">-----</option>
                    <option v-for="currency in currencies" v-bind:key="currency.id">
                        {{currency.currency}}
                    </option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Foreign Currency Amount</label>

                <input type="number" inputmode="numeric" min="1" v-on:blur="getTotalAmount()"
                       v-model="order.foreign_currency_amount"
                       class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>Total Order Amount USD</label>

                <input type="number" inputmode="numeric" min="1" v-on:blur="getForeignCurrencyAmount()"
                       v-model="order.total_amount"
                       class="form-control">
            </div>
        </div>

        <div class="row"
             v-if="order.total_amount && order.foreign_currency_amount && order.currency">
            <button v-on:click="createOrder()">Purchase</button>
        </div>

    </form>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';

// Reactive data
const currencies = ref([]);
const surchargeAmount = ref('');
const order = reactive({
    foreign_currency_amount: '',
    total_amount: '',
    currency: ''
});

// Methods
const fetchCurrencies = () => {
    window.axios.get(API_URL + "/currencies").then(response => {
        currencies.value = response.data;
    });
};

const getTotalAmount = () => {
    order.total_amount = '';
    window.axios.post(API_URL + "/get-total-amount", order)
        .then(response => {
            order.total_amount = response.data.total_amount;
        })
        .catch(error => {
            alert(error.response?.data?.message || 'An error occurred');
        });
};

const getForeignCurrencyAmount = () => {
    order.foreign_currency_amount = '';
    window.axios.post(API_URL + "/get-foreign-currency-amount", order)
        .then(response => {
            order.foreign_currency_amount = response.data.foreign_currency_amount;
        })
        .catch(error => {
            alert(error.response?.data?.message || 'An error occurred');
        });
};

const onSelect = () => {
    console.log(order.currency);
};

const createOrder = () => {
    window.axios.post(API_URL + "/orders", order)
        .then(response => {
            console.log(response);
            alert('Order created');
        })
        .catch(error => {
            alert(error.response?.data?.message || 'An error occurred');
        });
};

// Lifecycle
onMounted(() => {
    fetchCurrencies();
});
</script>