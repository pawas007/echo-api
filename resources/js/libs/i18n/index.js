import {createI18n} from "vue-i18n";
import en from './locales/en.json' assert {type: 'json'};
import ua from './locales/ua.json' assert {type: 'json'};

const loadLocaleMessages = {
    ua: ua,
    en: en
}
export default createI18n({
    locale: import.meta.env.VITE_DEFAULT_LOCALE,
    fallbackLocale: import.meta.env.VITE_DEFAULT_LOCALE,
    legacy: false,
    globalInjection: true,
    messages: loadLocaleMessages,
})
