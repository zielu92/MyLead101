<template>
    <div>
        <h1>Products</h1>
        <div class="row">
            <product-item v-for="product in products" :key="product.id" :product="product"></product-item>
        </div>
    </div>
</template>

<script>
import ProductItem from "./ProductItem";
export default {
    name: "Products",
    components: {ProductItem},
    data() {
        return {
            products: [],
        };
    },
    methods: {
        initData() {
            this.axios.get('/api/product')
                .then(({data}) => {
                        this.products = data;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    created() {
        this.initData();
    }
}
</script>

<style scoped>

</style>
