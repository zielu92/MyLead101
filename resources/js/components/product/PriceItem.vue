<template>
    <div class="col-2 card m-1">
        <h4>{{price.name}}</h4>
        <b>฿ {{price.price}}</b>
    </div>
</template>

<script>
export default {
    props: ['price'],
    name: "PriceItem"
}
</script>

<style scoped>

</style>
