<template>
<div>
    <h1>{{ user.name }}</h1>
    <p>{{ user.email }}</p>
    <div v-if="errorMessage">{{ errorMessage }}</div>
</div>
</template>

<script>
export default {
    data() {
        return {
            user: {},
            errorMessage: ''
        };
    },
    mounted() {
        this.fetchUserProfile();
    },
    methods: {
        fetchUserProfile() {
            this.$http.get(`/api/user/${this.userId}`)
                .then(response => {
                    this.user = response.data;
                })
                .catch(error => {
                    console.error("Error fetching user profile:", error);
                    this.errorMessage = "Failed to load user profile.";
                });
        }
    }
};
</script>
