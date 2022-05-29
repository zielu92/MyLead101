<template>
    <div>
        <h1>Add new product</h1>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" v-model="product.name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="name">Description</label>
            <input type="text" v-model="product.description" id="description" class="form-control">
        </div>
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" v-model="product.sku" id="sku" class="form-control">
        </div>
        <div>
            <h4>Variations</h4>
            <edit-price-item v-for="(price,index) in product.price" :key="index" :price="price" @removePrice="remove" />
        </div>
        <button @click="addPrice" class="btn btn-info mt-2">Add variation</button>
        <button @click="addProduct" class="btn btn-primary mt-2">Add product</button>
    </div>
</template>

<script>
import Auth from "../../Auth";
import axios from "axios";
import EditPriceItem from "./EditPriceItem";
export default {
    name: "AddProduct",
    components: {EditPriceItem},
    data() {
        return {
            product: {
                price: []
            }
        };
    },
    methods: {
        addProduct() {
            //remove temp id
            this.product.price.forEach((el) => {
                delete el['id'];
            })
            this.axios.post('/api/product', this.product)
                .then(({data}) => {
                    this.$router.push('/dashboard');
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        remove(e) {
            this.product.price.splice(e,1)
        },
        addPrice() {
            let tempId = this.product.price.length;
            this.product.price.push({name: '', price: '', id:tempId});
        },
    }
}
</script>

<style scoped>

</style>
