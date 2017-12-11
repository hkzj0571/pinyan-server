<template>
    <div>
        <Menu mode="horizontal" @on-select="toggle" :active-name="currentView" class="navbar_menu">
            <MenuItem name="Followed">
                我关注的人
            </MenuItem>
            <MenuItem name="Follower">
                关注我的人
            </MenuItem>
        </Menu>
        <component :is="currentView"></component>
    </div>
</template>

<script>
    import Followed from '../../../components/Users/Show/Followed'
    import Follower from '../../../components/Users/Show/Follower'
    export default {
        data() {
            return {
                currentView: 'Followed',
            }
        },
        created: function () {
        },
        components: {
            Followed,
            Follower
        },
        methods: {
            toggle(name) {
                this.currentView = name
            }
        }
    }
</script>