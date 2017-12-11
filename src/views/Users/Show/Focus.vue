<template>
    <div>
        <Menu mode="horizontal" @on-select="toggle" :active-name="currentView" class="navbar_menu">
            <MenuItem name="LikeArticles">
                <Icon type="android-list"></Icon>
                喜欢的文章
            </MenuItem>
            <MenuItem name="FocusTopic">
                <Icon type="android-bookmark"></Icon>
                关注的专题
            </MenuItem>
        </Menu>
        <component :is="currentView"></component>
    </div>
</template>

<script>
    import LikeArticles from '../../../components/Users/Show/LikeArticles'
    import FocusTopic from '../../../components/Users/Show/FocusTopic'
    export default {
        data() {
            return {
                currentView: 'LikeArticles',
            }
        },
        created: function () {
        },
        components: {
            LikeArticles,
            FocusTopic
        },
        methods: {
            toggle(name) {
                this.currentView = name
            }
        }
    }
</script>