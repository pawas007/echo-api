import {createWebHistory, createRouter} from "vue-router";
import PublicChat from "@/views/PublicChat.vue";
import Dashboard from "@/views/Dashboard.vue";
import Friends from "@/views/Friends/Friends.vue";
import Peoples from "@/views/Peoples.vue";


const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard,
    },
    {
        path: "/peoples",
        name: "Peoples",
        component: Peoples,
    },
    {
        path: "/public-chat",
        name: "Public chat",
        component: PublicChat,
    },
    {
        path: "/friends",
        name: "Friends",
        component: Friends,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
export default router;
