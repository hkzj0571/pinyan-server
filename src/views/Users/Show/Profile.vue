<template>
    <div>
        <Menu mode="horizontal" @on-select="toggle" :active-name="currentView" class="navbar_menu">
            <MenuItem name="Machine">
                <Icon type="help-buoy"></Icon>
                动态
            </MenuItem>
            <MenuItem name="ReleaseArticle">
                <Icon type="android-list"></Icon>
                文章
            </MenuItem>
            <MenuItem name="FocusTopic">
                <Icon type="chatbox-working"></Icon>
                评论
            </MenuItem>
        </Menu>
        <component :is="currentView"></component>
    </div>
</template>

<script>
    import ReleaseArticle from '../../../components/Users/Show/ReleaseArticle'
    import Machine from '../../../components/Users/Show/Machine'
    export default {
        data() {
            return {
                currentView:'Machine',
            }
        },
        components: {
            ReleaseArticle,
            Machine
        },
        methods: {
            toggle(name) {
                this.currentView = name
            }
        }
    }
</script>