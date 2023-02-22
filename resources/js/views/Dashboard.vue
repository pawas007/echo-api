<template>
    <div class="container"><h2 class="h2">{{ authUser.name }}</h2></div>
</template>
<script>
import {inject, computed} from 'vue'
import {useStore} from "vuex";

export default {
    name: "Dashboard",
    setup() {
        const authUser = computed(function () {
            return useStore().getters.AUTH_USER
        });
        return {authUser}
    }
}
</script>

