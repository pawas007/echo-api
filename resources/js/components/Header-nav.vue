<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm border-top">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'Dashboard' }">Dashboard</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" :to="{ name: 'Public chat' }">Public chat</router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Header-nav"
}
</script>

<style scoped>

</style>
