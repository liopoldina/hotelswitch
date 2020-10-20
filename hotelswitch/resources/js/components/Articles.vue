<template>
    <div>
        <h2>Articles</h2>
        <h3>{{msg}}</h3>
        <todos/>

    </div>
</template>


<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                msg:'Hello'
            }
        }
    }
</script>
