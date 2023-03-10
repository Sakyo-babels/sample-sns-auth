<template>
    <Header />
    <main>
        <router-view></router-view>
    </main>
    <Footer />
</template>

<script setup>
    import { ref, reactive, computed, watch } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useStore } from 'vuex';
    import Header from './components/Header.vue';
    import Footer from './components/Footer.vue';
    import { INTERNAL_SERVER_ERROR } from './util';

    const route = useRoute();
    const router = useRouter();
    const store  = useStore();

    const errorCode = computed(() => {
        return store.state.error.code;
    });

    watch(errorCode, (val) => {
        if (val === INTERNAL_SERVER_ERROR) {
            router.push('/500');
        }
    }, {immediate:true});
    watch(route, () => {
        store.commit('error/setCode', null);
    });
</script>

<style>
    main {
        padding: 20px;
    }
</style>
