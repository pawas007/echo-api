import {createI18n} from "vue-i18n";
import en from './locales/en.json' assert {type: 'json'};
import uk from './locales/uk.json' assert {type: 'json'};

const loadLocaleMessages = {
    uk: uk,
    en: en
}
export default createI18n({
    locale: import.meta.env.VITE_DEFAULT_LOCALE,
    fallbackLocale: import.meta.env.VITE_DEFAULT_LOCALE,
    legacy: false,
    globalInjection: true,
    messages: loadLocaleMessages,
})
