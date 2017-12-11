<template>
    <ul class="machines_list">
        <transition-group name="fade">
            <li v-for="(machine,index) in machines" :key="index">
                <Registerd v-if="machine.action == 'registerd'" :machine="machine"></Registerd>
                <NewArticle v-if="machine.action == 'article'" :machine="machine"></NewArticle>
                <Comment v-if="machine.action == 'comment'" :machine="machine"></Comment>
                <Follow v-if="machine.action == 'follow'" :machine="machine"></Follow>
                <Reply v-if="machine.action == 'reply'" :machine="machine"></Reply>
                <Like v-if="machine.action == 'like'" :machine="machine"></Like>
                <Vote v-if="machine.action == 'vote'" :machine="machine"></Vote>
            </li>
        </transition-group>
        <li class="end">
            <Button type="text" icon="chevron-down" :loading="loading" v-show="!end" @click="getMachines">加载更多</Button>
            <Button type="text" v-show="end">加载完毕</Button>
        </li>
    </ul>
</template>

<script>
    import Registerd from '../Machines/Registerd'
    import NewArticle from '../Machines/Article'
    import Comment from '../Machines/Comment'
    import Follow from '../Machines/Follow'
    import Reply from '../Machines/Reply'
    import Like from '../Machines/Like'
    import Vote from '../Machines/Vote'
    export default {
        data() {
            return {
                loading: false,
                end: false,
                page: 0,
                machines: []
            }
        },
        created: function () {
            this.getMachines()
        },
        components: {
            Registerd,
            NewArticle,
            Comment,
            Reply,
            Like,
            Vote,
            Follow
        },
        methods: {
            getMachines(){
                this.loading = true
                this.page++
                this.$axios.get('user/machines?page=' + this.page, {}).then(resource => {
                    this.loading = false
                    if (resource.data.data.machines.length === 0) {
                        this.end = true
                    }
                    this.machines = this.machines.concat(resource.data.data.machines)
                })
            }
        }
    }
</script>