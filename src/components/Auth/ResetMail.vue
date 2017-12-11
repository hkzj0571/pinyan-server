<template>
    <div class="container no-active">
        <Alert show-icon>
            <template slot="desc">我们已经向您的邮箱地址发送了一封账号验证邮件， 为了你的账号安全，请尽快验证。
                <Button v-show="is_show" :loading="loading" type="text" @click="resetMail" icon="paper-airplane">重新发送
                </Button>
            </template>
        </Alert>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                is_show: true,
                loading: false
            }
        },
        computed: {},
        methods: {
            resetMail: function () {
                this.loading = true
                this.$axios.get('reset', {}).then(resource => {
                    let respond = resource.data
                    this.loading = false
                    this.is_show = false
                    return respond.status ? this.$Message.success(respond.message) : this.$Message.error(respond.message)
                })
            },
        },
    }
</script>