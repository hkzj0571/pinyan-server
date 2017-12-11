<template>
    <div class="layout">
        <IndexHeader></IndexHeader>
        <div class="container">
            <i-col :span="7">
                <Menu class="drak_bar" :active-name="currentView" @on-select="toggle">
                    <MenuItem name="Basic">
                        <div class="icon">
                            <Icon type="android-settings"></Icon>
                        </div>
                        基础设置
                    </MenuItem>
                    <MenuItem name="Profile">
                        <div class="icon">
                            <Icon type="person"></Icon>
                        </div>
                        个人资料
                    </MenuItem>
                    <MenuItem name="Badge">
                        <div class="icon">
                            <Icon type="ribbon-b"></Icon>
                        </div>
                        我的徽章
                    </MenuItem>
                </Menu>
            </i-col>
            <i-col :span="16" offset="1">
                <component :is="currentView"></component>
            </i-col>
        </div>
    </div>
</template>

<script>
    import IndexHeader from '../../../components/Commons/Header.vue'
    import Basic from '../../../components/Users/Settings/Basic'
    import Profile from '../../../components/Users/Settings/Profile'
    import Badge from '../../../components/Users/Settings/Badge'

    export default {
        data(){
            return {
                currentView: 'Basic'
            }
        },
        components: {
            IndexHeader,
            Basic,
            Profile,
            Badge
        },
        methods:{
            toggle(name) {
                this.currentView = name
            }
        }
    }
</script>