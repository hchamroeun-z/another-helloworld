import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        id: null,
        name: null,
        email: null
    }),
    getters: {
        isAuthenticated: (state) => !!state.id,
    },
    actions: {
        setState(user) {
            this.id = user.id;
            this.name = user.name;
            this.email = user.email;
        },
        resetState() {
            this.id = null,
                this.name = null,
                this.email = null
        },
        setSanctumToken(token) {
            localStorage.setItem("SANCTUM-TOKEN", token);
        },
        getSanctumToken() {
            return localStorage.getItem("SANCTUM-TOKEN");
        },
        removeSanctumToken() {
            localStorage.removeItem("SANCTUM-TOKEN");
        },
        reset() {
            this.resetState();
            this.removeSanctumToken();
        }
    }, persist: true,
});