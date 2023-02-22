import {createStore} from "vuex";
import user from "@/store/user";


const modules = {
    user
}


export default createStore({
    modules: modules
});
