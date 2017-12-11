<template>
    <div class="layout">
        <IndexHeader></IndexHeader>
        <div class="container">
            <i-col :span="16">
                <div class="topic-header">
                    <a class="cover">
                        <img :src="topic.cover">
                    </a>
                    <Button type="success" class="focus" :class="{active:is_focus}" :icon="focus_cion" shape="circle" @click="toggleFocus">{{ focus_text }}</Button>
                    <div class="title">
                        <a class="name" href="/c/1hjajt" v-text="topic.name"></a>
                    </div>
                    <div class="info">
                        收录了 {{ topic.article_count }} 篇文章 · {{ topic.follower_count }} 人关注
                    </div>
                </div>
                <Menu mode="horizontal" @on-select="toggle" :active-name="currentView" class="navbar_menu">
                    <MenuItem name="NewArticle">
                        <Icon type="android-time"></Icon>
                        最新文章
                    </MenuItem>
                    <MenuItem name="HotArticle">
                        <Icon type="flame"></Icon>
                        热门文章
                    </MenuItem>
                    <MenuItem name="HotArticle">
                        <Icon type="trophy"></Icon>
                        最佳榜单
                    </MenuItem>
                    <MenuItem name="FineAuthor">
                        <Icon type="ribbon-b"></Icon>
                        优秀作者
                    </MenuItem>
                </Menu>
                <component :is="currentView"></component>
            </i-col>
            <i-col :span="7" offset="1">
                <div class="aside">
                    <p class="title">专题公告</p>
                    <div class="description" v-html="topic.describe"></div>
                    <div class="share">
                        <span>分享到</span>
                        <share :config="{disabled:['google','facebook','diandian','tencent','linkedin','twitter']}"></share>
                    </div>
                    <div class="manage">
                        <p class="title">管理员</p>
                        <ul class="collection">
                            <li v-for="user in topic.manages">
                                <a :href="'/topics/'+topic.id">
                                    <Avatar icon="person" shape="square" :src="user.avatar"></Avatar>
                                    {{ user.name }}
                                    <span class="tag" v-if="user.is_creator == 1">创建者</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-action" v-if="topic.creator.id == user_id">
                        <router-link :to="'/topics/'+topic.id+'/edit'">
                            <Button type="text" icon="android-create">编辑专题</Button>
                        </router-link>
                        <!--<Button type="text" icon="android-delete">删除专题</Button>-->
                    </div>
                </div>
            </i-col>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import 'vue-social-share/dist/client.css'
    import IndexHeader from '../../components/Commons/Header.vue'
    import FineAuthor from '../../components/Topics/Indexs/FineAuthor.vue'
    import HotArticle from '../../components/Topics/Indexs/HotArticle.vue'
    import NewArticle from '../../components/Topics/Indexs/NewArticle.vue'

    export default {
        data() {
            return {
                currentView: 'NewArticle',
                is_focus: false,
                topic: {
                    creator:{}
                },
            }
        },
        components: {
            IndexHeader,
            FineAuthor,
            HotArticle,
            NewArticle,
        },
        computed: {
            focus_cion() {
                return this.is_focus ? 'checkmark-round' : 'plus-round'
            },
            focus_text() {
                return this.is_focus ? '已关注' : '关注'
            },
            ...mapState({
                user_id: state => state.user.id,
            })
        },
        methods: {
            toggle(name) {
                this.currentView = name
            },
            toggleFocus() {
                this.is_focus = !this.is_focus
                this.$axios.post(`topics/${this.$route.params.topic}/focus`, {}).then(resource => {
                    let respond = resource.data
                    respond.data.type == 'attached' ? this.topic.follower_count++ : this.topic.follower_count--
                })
            },
        },
        created: function () {
            this.$axios.post(`topics/${this.$route.params.topic}/is_focus`, {}).then(resource => {
                let respond = resource.data
                this.is_focus = respond.data.is_focus
            })

            this.$axios.post(`topics/${this.$route.params.topic}`, {}).then(resource => {
                let respond = resource.data
                this.topic = respond.data.topic
            })
        }
    }
</script>