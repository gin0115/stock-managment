import { defineStore } from 'pinia'

export const useWpStore = defineStore({
    id: 'wpStore',
    state: () => ({
        i18n: stockMan.i18n.app,
        user: stockMan.user,
        settings: stockMan.settings,
    })
})