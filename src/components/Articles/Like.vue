<template>
    <div style="display: inline-block">
        <div class="like">
            <div class="btn like-group" :class="{active:article.is_like}">
                <div class="btn-like" @click="like">
                    <a href="javascript:void(0);">
                        <Icon :type="icon"></Icon>
                        喜欢
                    </a>
                </div>
                <div class="modal-wrap" @click="showModal"><a v-text="article.like_count"></a></div>
            </div>
        </div>
        <Modal v-model="modal" class="likes_user" title="喜欢的用户">
            <ul>
                <li v-for="user in users">
                    <a href="/u/e8d95cca28b8" target="_blank" class="avatar">
                        <Avatar icon="person" :src="user.avatar" size="large"/>
                    </a>
                    <a href="/u/e8d95cca28b8" target="_blank" class="name" v-text="user.name"></a>
                    <Icon :type="user.gender" v-show="user.gender"></Icon>
                    <a href="" class="time" v-text="user.pivot_created_at"></a>
                </li>
                <li class="end">
                    <Button type="text" icon="chevron-down" :loading="loading" v-show="!end" @click="getUser">加载更多
                    </Button>
                    <Button type="text" v-show="end">加载完毕</Button>
                </li>
            </ul>
            <div slot="footer"></div>
        </Modal>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                end: false,
                modal: false,
                loading: false,
                users: [],
                page: 0,
            }
        },
        computed: {
            icon() {
                return this.article.is_like ? 'android-favorite' : 'android-favorite-outline'
            }
        },
        props: ['article'],
        created: function () {
            this.getUser()
        },
        methods: {
            like() {
                this.$axios.post(`article/${this.article.id}/like`, {}).then(resource => {
                    let respond = resource.data
                    this.article.is_like = respond.data.type
                    respond.data.type ? this.article.like_count++ : this.article.like_count--
                })
            },
            showModal() {
                this.modal = true
            },
            getUser() {
                this.loading = true
                this.page++
                return this.$axios.post(`article/${this.$route.params.article}/users?page=${this.page}`, {}).then(resource => {
                    let respond = resource.data
                    this.loading = false
                    this.users = this.users.concat(respond.data.users)
                    if (respond.data.users.length == 0) {
                        this.end = true
                    }
                })
            }
        },
    }
</script>