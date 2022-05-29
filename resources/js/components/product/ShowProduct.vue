<template>
    <div class="jumbotron mt-3">
        <h1>{{product.name}}</h1>
        <p class="lead">{{product.description}}</p>
        <p class="text-end">SKU: {{product.sku}}</p>
        <h3>Variations</h3>
        <div class="row m-2">
            <price-item v-for="price in product.price" :key="price.id" :price="price"></price-item>
        </div>
        <router-link :to="'/product/edit/'+product.id" class="btn btn-lg btn-outline-secondary"  v-if="user">Edit</router-link>
        <button class="btn btn-lg btn-danger" @click="remove" v-if="user">Remove</button>
    </div>
</template>

<script>
import PriceItem from "./PriceItem";
export default {
    name: "ShowProduct",
    components: {PriceItem},
    data() {
        return {
            product: {},
            user: this.auth
        };
    },
    methods: {
        initData() {
            this.axios.get(`/api/product/${this.$route.params.id}`)
                .then(({data}) => {
                    this.product = data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        remove() {
            this.axios.delete(`/api/product/${this.$route.params.id}`)
                .then(({data}) => {
                    this.$router.push('/dashboard');
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.initData();
    }
}
</script>

<style scoped>

</style>
