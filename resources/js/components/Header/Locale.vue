<template>
    <div>
        <button
            class="locale_btn"
            v-for="locale in availableLocales"
            @click="changeLocale(locale.slug)"
            :class="{'active':currentLocale === locale.slug}"
        >
            <img :src="locale.ico" alt="">
        </button>
    </div>
</template>

<script>
import {reactive, ref} from "vue";
import {useI18n} from "vue-i18n";
import ukIcon from '@/assets/icons/united-kingdom.png'
import uaIcon from '@/assets/icons/ukraine.png'

export default {
    name: "Locale",
    setup() {
        const availableLocales = reactive(
            [
                {slug: 'en', name: 'English', ico: ukIcon},
                {slug: 'ua', name: 'Ukraine', ico: uaIcon},
            ]
        )
        const currentLocale = ref(import.meta.env.VITE_DEFAULT_LOCALE);
        const {locale} = useI18n()

        const changeLocale = (val) => {
            currentLocale.value = val
            locale.value = val
        }

        return {
            changeLocale,
            availableLocales,
            currentLocale
        }
    }
}
</script>

<style scoped lang="scss">
.locale_btn{
    outline: none;
    border: navajowhite;
    background: none;
    border-radius: 50%;
    img{
            border-radius: 50%;
            border: 4px solid transparent;
        }

    &.active{
        img{
            border-radius: 50%;
            border: 4px solid #5c636a;
        }
    }

}
</style>
