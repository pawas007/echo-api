<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-it">
                <router-link class="nav-link" :to="{ name: 'Dashboard' }"> {{ $t("nav.Home") }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Peoples' }">{{ $t("nav.Peoples") }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Friends' }">{{ $t("nav.Friends") }}</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Public chat' }">{{ $t("nav.Public chat") }}</router-link>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: "Header-nav",

}
</script>

