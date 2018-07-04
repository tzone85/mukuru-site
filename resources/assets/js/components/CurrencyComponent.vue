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

<script>
    export default {
        mounted() {
            this.fetchCurrencies();
        },
        data() {
            return {
                currencies: [],
                surchargeAmount: '',
                order: {
                    foreign_currency_amount: '',
                    total_amount: '',
                    currency: ''
                }
            }
        },
        methods: {
            fetchCurrencies() {
                this.$http.get(API_URL + "/currencies").then(response => {
                    this.currencies = response.data
                });
            },
            getTotalAmount() {
                this.order.total_amount = '';
                this.$http.post(API_URL + "/get-total-amount", this.order)
                    .then(response => {
                        this.order.total_amount = response.data.total_amount;
                    })
                    .catch(error => {
                        alert(error.body.message)
                    });
            },
            getForeignCurrencyAmount() {
                this.order.foreign_currency_amount = '';
                this.$http.post(API_URL + "/get-foreign-currency-amount", this.order)
                    .then(response => {
                        this.order.foreign_currency_amount = response.data.foreign_currency_amount;
                    })
                    .catch(error => {
                        alert(error.body.message)
                    });
            },
            onSelect() {
                console.log(this.order.currency)
            },
            createOrder() {
                this.$http.post(API_URL + "/orders", this.order)
                    .then(response => {
                        console.log(response);
                        alert('Order created');
                    })
                    .catch(error => {
                        alert(error.body.message)
                    });
            }
        },
    }
</script>
