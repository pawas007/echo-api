<template>
    <div>
        <div class="mt-5" v-if="!friends.length">
            <h5 class="h5">{{ $t("No friend") }}</h5>
        </div>
        <div class="row border-bottom mb-2 py-2" v-for="user in friends">
            <div class="col-md-2 col-sm-2">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                     class="profile-photo-lg">
            </div>
            <div class="col-md-7 col-sm-7">
                <h5><p class="profile-link">{{ user.name }}</p></h5>
                <p>{{ user.email }}</p>
            </div>
            <div class="col align-self-center d-flex justify-content-end">
                <button class="btn btn-secondary pull-right" @click="removeFriend(user.id)"> {{ $t("Remove friend") }}
                </button>
            </div>
        </div>
        <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
            <paginate
                v-model="paginator.currentPage"
                :page-count="paginator.pageCount"
                :page-range="3"
                :margin-pages="1"
                :click-handler="friendslist"
                prev-text="<"
                next-text=">"
                :container-class="'pagination'"
                :page-class="'page-item'"
            >
            </paginate>
        </div>
    </div>
</template>

<script>
import Paginate from "vuejs-paginate-next";
import axios from "axios";
import {onBeforeMount, reactive, ref} from "vue";

export default {
    name: "MyFriends",
    components: {
        Paginate
    },

    setup() {
        const friends = ref([])
        const paginator = reactive({
            currentPage: 1,
            pageCount: 0,
        })

        const removeFriend = (user) => {
            axios.get(`friend/${user}/delete`).then(() => {
                friendslist(paginator.currentPage)
            }).catch(({response}) => {
                console.error(response)
            })
        }

        const friendslist = async (page = 1) => {
            await axios.get(`friend?page=${page}`).then(({data}) => {
                friends.value = data.data
                paginator.pageCount = data.last_page
            }).catch(({response}) => {
                console.error(response)
            })
        }

        onBeforeMount(() => {
            friendslist()
        })

        return {friendslist, removeFriend,friends,paginator}
    },

}
</script>

