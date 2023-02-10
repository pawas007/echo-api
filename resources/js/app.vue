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

export default {
    name: "app",
    components: {PushNotifications, Locale, HeaderNav}
}
</script>

<!--TODO : GET USERS WITH STATUS REFACTOR-->
<!--TODO : Update Friends count-->
<!--TODO : Delete & MarkRead notification-->
<!--TODO : Refactor same code-->
<!--TODO : Save public messages-->

