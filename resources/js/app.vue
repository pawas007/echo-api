<template>
    <div>
        <Teleport to="#teleport-nav">
            <header-nav/>
        </Teleport>
        <div class="py-4">
            <router-view/>
        </div>
        <notifications/>
    </div>
</template>
<script>
import Chat from "@/views/PublicChat.vue";
import HeaderNav from "@/components/Header-nav.vue";

export default {
    name: "app",
    components: {HeaderNav, Chat}
}
</script>

