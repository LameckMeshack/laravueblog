<template>
    <div>
        <h1>This is the first component</h1>
        <RouterView/>
    </div>
</template>
<style>
   
</style>

<script>
import { RouterView } from 'vue-router';


    export default{
    components: { RouterView }
}
</script>