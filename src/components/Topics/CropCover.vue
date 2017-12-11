<template>
    <div>
        <Upload action="http://up-z2.qiniu.com"
                :max-size="3072"
                :data="token"
                :show-upload-list="false"
                :format="['jpg','jpeg','png','gif']"
                :before-upload="getUploadToken"
                :on-format-error="FormatError"
                :on-success="uploadSucceed"
                :on-error="uploadFail"
                :on-exceeded-size="exceededSize"
        >
            <Avatar shape="square" v-show="url" :src="url" size="large"/>
            <Button type="ghost" icon="android-upload" shape="circle" size="large" v-show="!url" class="wechat_upload" :loading="crop_vistal">上传专题封面</Button>
        </Upload>
        <p class="help">选取一张图片作为专题的封面</p>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                crop_vistal: false,
                token: null,
            }
        },
        components: {},
        props: {
            value: String,
        },
        computed: {
            url: {
                get: function () {
                    return this.value
                },
                set: function (value) {
                    this.$emit('input', value)
                }
            }
        },
        methods: {
            FormatError(){
                this.crop_vistal = false
                return this.$Message.error('文件格式错误')
            },
            uploadFail(){
                this.crop_vistal = false
                return this.$Message.error('文件上传失败，请重试')
            },
            exceededSize(){
                this.crop_vistal = false
                return this.$Message.error('图片最大为3M')
            },
            uploadSucceed(response){
                this.url = this.$env.oss_domain + response.key
                this.crop_vistal = false
            },
            getUploadToken(){
                this.crop_vistal = true

                return this.$axios.get('upload/token', {}).then(resource => {
                    let respond = resource.data
                    this.token = respond.data
                })
            },
        }
    }
</script>