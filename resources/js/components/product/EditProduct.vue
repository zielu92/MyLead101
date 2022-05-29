<template>
    <div>
        <h1>Edit {{product.name}}</h1>
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
            <edit-price-item v-for="price in product.price" :key="price.id" :price="price" @removePrice="remove" @updatePrice="update" />
        </div>
        <button @click="addPrice" class="btn btn-info mt-2">Add variation</button>
        <button @click="editProduct" class="btn btn-primary mt-2">Edit product</button>
    </div>
</template>

<script>
import EditPriceItem from "./EditPriceItem";
export default {
    name: "EditProduct",
    components: {EditPriceItem},
    data() {
        return {
            product: {}
        };
    },
    methods: {
        editProduct() {
            this.axios.put(`/api/product/${this.$route.params.id}`, this.product)
                .then(({data}) => {
                    //this.$router.push('/dashboard');
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        initData() {
            this.axios.get(`/api/product/${this.$route.params.id}`)
                .then(({data}) => {
                    this.product = data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addPrice() {
            this.product.price.push({name: '', price: ''});
        },
        update(e) {
            if(e.id) {
                //in case the price exists in db
                this.axios.put(`/api/price/${e.id}`, e)
                    .then(({data}) => {
                        this.initData();
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                //in case we are adding new value to db
                if(!!e.name && !!e.price) {
                    e['products_id'] = this.product.id;
                    this.axios.post(`/api/price`, e)
                        .then(({data}) => {
                            this.initData();
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                }
            }

        },
        remove(e) {
            //TODO: in case it has no id
            this.axios.delete(`/api/price/${e}`)
                .then(({data}) => {
                    this.initData();
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
