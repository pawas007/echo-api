<template>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Dashboard' }">Dashboard</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Peoples' }"> Peoples</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Friends' }">Friends</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'Public chat' }">Public chat</router-link>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    name: "Header-nav"
}
</script>

