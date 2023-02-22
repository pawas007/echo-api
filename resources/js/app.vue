<template>
    <div>
        <Teleport to="#notificationsList">
            <push-notifications/>
        </Teleport>
        <Teleport to="#teleport-nav">
            <header-nav/>
        </Teleport>
        <Teleport to="#locale">
            <Locale/>
        </Teleport>
        <div class="py-4">
            <router-view/>
        </div>
        <notifications/>
    </div>
</template>
<script>
import HeaderNav from "@/components/Header/Header-nav.vue";
import Locale from "@/components/Header/Locale.vue";
import PushNotifications from "@/components/Header/PushNotifications.vue";
import {useStore} from "vuex";

export default {
    name: "app",
    components: {PushNotifications, Locale, HeaderNav},

    setup() {
        useStore().dispatch('GET_AUTH_USER')
        useStore().dispatch('GET_AUTH_USER_SETTINGS')

    }


}
</script>


<!--TODO : Update Friends count-->
<!--TODO : Save public messages-->

