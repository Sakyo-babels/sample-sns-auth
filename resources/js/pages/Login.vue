<template>
    <h2>Loginページ</h2>
    <div>
        <router-link to="/">Topページ</router-link>
    </div>
    <div>
        <form @submit.prevent="login">
            <div v-if="loginErrors" class="errors">
                <ul v-if="loginErrors.email">
                    <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                </ul>
                <ul v-if="loginErrors.password">
                    <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            <input type="text" v-model="form.email" placeholder="メールアドレスを入力してください"><br>
            <input type="password" v-model="form.password" placeholder="パスワードを入力してください">
            <div>
                <button type="submit">ログイン</button>
            </div>
        </form>
    </div>
    <div>
        <router-link to="/social-login">ソーシャルログイン</router-link>
    </div>
</template>

<script setup lang="ts">
	import { ref, reactive, computed } from 'vue';
	import { useRoute, useRouter } from 'vue-router';
	import { useStore } from 'vuex';

	const router = useRouter();
	const store  = useStore();

	const form = reactive({
		email: '',
		password: '',
	});

	const login = async () => {
		await store.dispatch('auth/login', form);
		if (apiStatus.value) {
			router.push('/');
		}
	}

	const apiStatus = computed(() => {
		return store.state.auth.apiStatus;
	});

	const loginErrors  = computed(() => {
		return store.state.auth.loginErrorMessages;
	});

    const clearError = () => {
        store.commit('auth/setLoginErrorMessages', null);
    }
    clearError();
</script>

<style scoped>
input {
	width: 300px;
}
</style>
