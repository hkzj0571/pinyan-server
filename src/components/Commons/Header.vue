<template>
    <div class="header">
        <Menu mode="horizontal" active-name="1">
            <div class="header-logo">
                <router-link to="/"></router-link>
            </div>
            <div class="container">
                <div class="header-nav">
                    <MenuItem name="1">
                        首页
                    </MenuItem>
                    <MenuItem name="2">
                        热门
                    </MenuItem>
                    <MenuItem name="5">
                        专题
                    </MenuItem>
                    <MenuItem name="3" class="header-search">
                        <i-input placeholder="搜索" icon="ios-search"/>
                    </MenuItem>
                    <MenuItem name="4" class="header-register" v-if="!authenticated">
                        <router-link to="/login">
                            <Button shape="circle">登陆</Button>
                        </router-link>
                    </MenuItem>
                    <MenuItem name="4" class="header-user" v-if="authenticated">
                        <Dropdown>
                            <router-link :to="{name:'user.show.profile',params:{user:id}}">
                                <Avatar :src="avatar" shape="square" size="large"/>
                            </router-link>
                            <DropdownMenu slot="list">
                                <router-link :to="{name:'user.show.profile',params:{user:id}}">
                                    <DropdownItem name="profile">
                                        <Icon type="person"></Icon>
                                        我的主页
                                    </DropdownItem>
                                </router-link>
                                <router-link :to="{name:'user.settings'}">
                                    <DropdownItem name="setting">
                                        <Icon type="android-settings"></Icon>
                                        个人设置
                                    </DropdownItem>
                                </router-link>
                                <router-link :to="{name:'user.show.focus',params:{user:id}}">
                                    <DropdownItem name="logout">
                                        <Icon type="android-favorite"></Icon>
                                        喜欢的文章
                                    </DropdownItem>
                                </router-link>
                                <router-link :to="{name:'user.show.follow',params:{user:id}}">
                                    <DropdownItem name="logout">
                                        <Icon type="eye"></Icon>
                                        关注的用户
                                    </DropdownItem>
                                </router-link>
                                <router-link to="/">
                                    <DropdownItem name="logout">
                                        <Icon type="android-textsms"></Icon>
                                        帮助与反馈
                                    </DropdownItem>
                                </router-link>
                                <a href="javascript:void(0);" @click="logout">
                                    <DropdownItem name="logout">
                                        <Icon type="power"></Icon>
                                        退出登陆
                                    </DropdownItem>
                                </a>
                            </DropdownMenu>
                        </Dropdown>
                    </MenuItem>
                    <MenuItem name="3" class="header-notification" v-if="authenticated">
                        <Dropdown trigger="click">
                            <a href="javascript:void(0)">
                                <Badge count="" overflow-count="10">
                                <Icon type="android-notifications"></Icon>
                                </Badge>
                            </a>
                            <DropdownMenu slot="list">
                            </DropdownMenu>
                        </Dropdown>
                    </MenuItem>
                    <MenuItem name="4" class="header-article" v-if="authenticated">
                        <router-link to="/article">
                            <Button shape="circle" icon="android-list" >写文章</Button>
                        </router-link>
                    </MenuItem>
                </div>
            </div>
        </Menu>
        <ResetMail v-if="authenticated && !is_active"></ResetMail>
    </div>
</template>
<script>
    import ResetMail from '../Auth/ResetMail.vue'
    import {mapState} from 'vuex'
    export default {
        data() {
            return {}
        },
        components: {
            ResetMail
        },
        computed: mapState({
            id: state => state.user.id,
            name: state => state.user.name,
            avatar: state => state.user.avatar,
            email: state => state.user.email,
            is_active: state => state.user.is_active,
            authenticated: state => state.user.authenticated,
        }),
        methods: {
            logout: function () {
                if (this.authenticated) {
                    this.$axios.get('logout').then(resource => {
                        let respond = resource.data
                        return respond.status ? this.$store.dispatch('unthenticated').then(() => {
                            this.$router.push('/')
                            return this.$Message.success(respond.message)
                        }) : this.$Message.error(respond.message)
                    })
                }
            }
        },
        mounted: function () {

        }
    }
</script>