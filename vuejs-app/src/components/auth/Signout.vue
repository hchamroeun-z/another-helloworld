<template>
</template>

<script setup>
import { apiSignout } from '@/functions/api/auth';
import { onMounted } from 'vue';
import {useUserStore} from '@/stores/user';
import { useRouter } from 'vue-router';

onMounted(async()=>{
    const userStore=useUserStore();
    const router=useRouter();

    const token=userStore.getSanctumToken();
    apiSignout(token);
    userStore.reset();
    router.replace({name:'auth.signin'});
});
</script>