<template>
    <div>
        <quill-editor class="article-quill" ref="ArticleQuill" v-model="content" :options="editorOption"></quill-editor>
        <Upload action="http://up-z2.qiniu.com"
                :max-size="3072"
                :data="token"
                id="ArticleQuillImage"
                :show-upload-list="false"
                :format="['jpg','jpeg','png','gif']"
                :before-upload="getUploadToken"
                :on-format-error="FormatError"
                :on-success="uploadSucceed"
                :on-error="uploadFail"
                :on-exceeded-size="exceededSize"
        >
        </Upload>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                addRange: null,
                token: null,
                editorOption: {
                    placeholder: '请输入正文',
                    modules: {
                        toolbar: [
                            [{'header': 1}, {'header': 2}],
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block', 'image','link'],
                            [{'list': 'ordered'}, {'list': 'bullet'}],
                            ['clean']
                        ]
                    },
                    theme: 'snow'
                }
            }
        },
        props: {
            value: String,
        },
        methods: {
            FormatError(){
                this.$Spin.hide()
                return this.$Message.error('文件格式错误')
            },
            uploadFail(){
                this.$Spin.hide()
                return this.$Message.error('文件上传失败，请重试')
            },
            exceededSize(){
                this.$Spin.hide()
                return this.$Message.error('图片最大不能超过3M')
            },
            uploadSucceed(response){
                this.$Spin.hide()
                var url = this.$env.oss_domain + response.key
                var range = this.$refs.ArticleQuill.quill.getSelection()
                this.$refs.ArticleQuill.quill.insertEmbed(range !== null ? range.index : 0, 'image', url)
            },
            getUploadToken(file){
                this.$Spin.show({
                    render: (h) => {
                        return h('div', [
                            h('Icon', {
                                'class': 'spin-icon-load',
                                props: {
                                    type: 'load-c',
                                    size: 18
                                }
                            }),
                            h('div', '文件上传中...')
                        ])
                    }
                });

                return this.$axios.get('upload/token', {}).then(resource => {
                    let respond = resource.data
                    this.token = respond.data
                })
            },
            imgHandler(){
                let input = document.querySelector('.ivu-upload-input')
                input.click()
            }
        },
        computed: {
            content: {
                get: function () {
                    return this.value
                },
                set: function (value) {
                    this.$emit('input', value)
                }
            }
        },
        mounted() {
            this.$refs.ArticleQuill.quill.getModule('toolbar').addHandler('image', this.imgHandler)
        }
    }
</script>