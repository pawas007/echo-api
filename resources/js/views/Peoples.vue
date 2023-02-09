<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h3 class="h3 border-bottom pb-3">{{ $t("Peoples") }}</h3>
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
                        <button class="btn btn-secondary pull-right" @click="addFriend(user.id)"> {{ $t("Add friend") }}
                        </button>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-center" v-if="paginator.pageCount > 1">
                    <paginate
                        v-model="paginator.currentPage"
                        :page-count="paginator.pageCount"
                        :page-range="3"
                        :margin-pages="1"
                        :click-handler="usersList"
                        prev-text="<"
                        next-text=">"
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
import {useI18n} from "vue-i18n";
import {onBeforeMount, ref, reactive} from "vue";
import {notify} from "@kyvg/vue3-notification";

export default {
    name: "Peoples",
    components: {
        Paginate
    },
    setup() {
        const {t} = useI18n();
        const users = ref([]);
        const paginator = reactive({
            currentPage: 1,
            pageCount: 0,
        })

        onBeforeMount(() => {
            usersList()
        })

        const addFriend = (id) => {
            axios.get(`friend/${id}/add`).then((r) => {
                if (r.status === 201)
                    notify({
                        type: 'success',
                        title: t('Friend request sent'),
                        text: r.data.name,
                    })
            });
        }
        const usersList = (page = 1) => {
            axios.get(`users?page=${page}`).then(({data}) => {
                users.value = data.data
                paginator.pageCount = data.last_page
            }).catch(({response}) => {
                console.error(response)
            })
        }

        return {addFriend, usersList, paginator, users}
    },
}
</script>

