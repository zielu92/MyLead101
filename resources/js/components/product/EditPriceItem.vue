<template>
<div class="row">
    <div class="form-group col-6">
        <label for="pname">Variation name</label>
        <input type="text" v-model="price.name" id="pname" class="form-control" @change="updatePrice">
    </div>
    <div class="form-group col-5">
        <label for="pprice">Price</label>
        <input type="text" v-model="price.price" id="pprice" class="form-control" @change="updatePrice">
    </div>
    <div class="form-group col-1">
        <br>
        <button @click="removePrice" class="btn btn-danger">Del</button>
    </div>
</div>
</template>

<script>
export default {
    props: ['price'],
    name: "EditPriceItem",
    methods: {
        updatePrice(e) {
            this.$emit('updatePrice', this.price);
        },
        removePrice(e) {
            this.$emit('removePrice', this.price.id);
        }
    }
}
</script>

<style scoped>

</style>
