<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="h3 border-bottom pb-3">Peoples</h3>
                <div class="row border-bottom mb-2 py-2 " v-for="user in users">
                    <div class="col-md-2 col-sm-2">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user"
                             class="profile-photo-lg">
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h5><p class="profile-link">{{ user.name }}</p></h5>
                        <p>{{ user.email }}</p>
                        <!--                                <p class="text-muted">500m away</p>-->
                    </div>
                    <div class="col align-self-center d-flex justify-content-end">
                        <button class="btn btn-primary pull-right" @click="addFriend(user.id)">Add Friend
                        </button>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
                    <paginate
                        v-model="paginator.currentPage"
                        :page-count="paginator.pageCount"
                        :page-range="3"
                        :margin-pages="1"
                        :click-handler="userslist"
                        :prev-text="'Prev'"
                        :next-text="'Next'"
                        :container-class="'pagination'"
                        :page-class="'page-item'"
                    >
                    </paginate>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Paginate from "vuejs-paginate-next";

export default {
    name: "Peoples",

    components: {
        Paginate
    },
    data() {
        return {
            paginator: {
                currentPage: 1,
                pageCount: 0,
            },
            users: {
                type: Array,
                default: []
            }
        }
    },
    mounted() {
        this.userslist()

    },
    methods: {
        addFriend(id) {
            axios.get(`friend/${id}/add`).then((r) => {

                if (r.status == 203)
                    this.$notify({
                        type: 'success',
                        title: "Send friend request",
                        text: r.data.name,
                    })
            });
        },

        async userslist(page = 1) {
            await axios.get(`users?page=${page}`).then(({data}) => {
                this.users = data.data
                this.paginator.pageCount = data.last_page
            }).catch(({response}) => {
                console.error(response)
            })
        }
    },


}


</script>

<style scoped>

</style>
