import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
    state: () => ({
        id: null,
        name: null,
        email: null,
        profile_image: null,
        profile_thumbnail: null,
        password_null: true,
    }),
    getters: {
        isAuthenticated: (state) => !!state.id,
    },
    actions: {
        setState(user) {
            this.id = user.id;
            this.name = user.name;
            this.email = user.email;
            this.profile_image = user.profile_image;
            this.profile_thumbnail = user.profile_thumbnail;
            this.password_null = user.password_null;
        },
        resetState() {
            this.id = null;
            this.name = null;
            this.email = null;
            this.profile_image = null;
            this.profile_thumbnail = null;
            this.password_null = true;
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