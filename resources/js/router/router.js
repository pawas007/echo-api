import {createWebHistory, createRouter} from "vue-router";
import PublicChat from "@/views/PublicChat.vue";
import Dashboard from "@/views/Dashboard.vue";


const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
    },
    {
        path: "/public-chat",
        name: "Public chat",
        component: PublicChat,
    },


];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
