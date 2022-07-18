/**
 * Handle all UI state for the location page
 */
import { defineStore } from 'pinia'

export const useLocationStore = defineStore({
    id: 'locationStore',
    state: () => ({
        currentSite: 'ccc',
    }),
    getters: {
        getCurrentSite: state => state.currentSite,
    },
    actions: {
        setCurrentSite: (state, site) => {
            state.currentSite = site
        }
    }
})