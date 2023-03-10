<template>
    <div>
        <h2>Topページ</h2>
        <div v-if="isLogin">
            <p>ようこそ　{{ userName }}</p>
            <button @click="logout">Logout</button>
        </div>
        <div v-else>
            <div>
                <router-link to="/login">Login</router-link>
            </div>
            <div>
                <router-link to="/register">会員登録</router-link>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { ref, reactive, computed } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useStore } from 'vuex';

    const router = useRouter();
    const store  = useStore();

    const logout = async () => {
        await store.dispatch('auth/logout');
        if (apiStatus.value) {
			router.push('/login');
		}
    }

    const isLogin = computed(() => {
        return store.getters['auth/check'];
    });

    const userName = computed(() => {
        return store.getters['auth/userName'];
    });

    const apiStatus = computed(() => {
		return store.state.auth.apiStatus;
	});

    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = '';
    }
</script>
