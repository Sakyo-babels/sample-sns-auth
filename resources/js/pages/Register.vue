<template>
    <h2>会員登録ページ</h2>
    <div>
        <router-link to="/">Topページ</router-link>
    </div>
    <div>
        <form @submit.prevent="register">
            <div v-if="registerErrors" class="errors">
                <ul v-if="registerErrors.name">
                    <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                </ul>
                <ul v-if="registerErrors.email">
                    <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                </ul>
                <ul v-if="registerErrors.password">
                    <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                </ul>
            </div>
            <input type="text" v-model="form.name" placeholder="名前を入力してください"><br>
            <input type="text" v-model="form.email" placeholder="メールアドレスを入力してください"><br>
            <input type="password" v-model="form.password" placeholder="パスワードを入力してください"><br>
            <input type="password" v-model="form.password_confirmation" placeholder="パスワード(確認)を入力してください">
            <div>
                <button type="submit">登録する</button>
            </div>
        </form>
    </div>
    <div>
        <router-link to="/social-register">ソーシャル登録</router-link>
    </div>
</template>

<script setup lang="ts">
    import { ref, reactive, computed } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { useStore } from 'vuex';

    const router = useRouter();
    const store  = useStore();

    const form = reactive({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const register = async () => {
        await store.dispatch('auth/register', form);
		if (apiStatus.value) {
			router.push('/');
		}
    }

    const apiStatus = computed(() => {
		return store.state.auth.apiStatus;
	});

    const registerErrors  = computed(() => {
		return store.state.auth.registerErrorMessages;
	});

    const clearError = () => {
        store.commit('auth/setRegisterErrorMessages', null);
    }
    clearError();
</script>

<style scoped>
input {
    width: 300px;
}
</style>
