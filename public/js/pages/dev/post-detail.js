
new Vue({
    el: '#app',
    data: {
        message: 'only text',
        limit : 5,
        offset : 0,
        posts : [],
        recordCount : 1,
        isProcessing : true,
        isPosting : false,
        data : {
            brand : "",
            tags : "",
            category : "",
            price : "",
            address : "",
            keyword : "",
            limit : 5,
            offset : 0,
            page : 'detail'
        },

        post : {
            title : '',
            description : '',
            type : 'text',
            video : '',
            photo : '',
            fd: '',
        },

        typed: {
            address : "",
            keyword : "",
        },
        interval : 0,
        shops : [],
        url : window.url,
        count : 1,
        errors : {},
        value  : "no value",
        videoEmbedded : "",
        videoExist : true,
        readingVideo:false,
        video : "",
        videoFaileMessage : "",
        isInteracting : false,
        post_id : 0,
    },

    mounted() {
        this.url = window.url;
        this.post_id  = window.post_id;
        this.loadMore();
    },

    methods: {
        interaction : function(post, index, action) {
            this.isInteracting = true;
            let url = this.url + '/api/post/' + post.id + '/interaction';

            // Change ui in real time
            if(action == 'save') {
                if (this.posts[index].is_saved_by_auth_count == 1) {
                    this.posts[index].is_saved_by_auth_count = 0;
                    this.posts[index].post_saved_count--;
                } else {
                    this.posts[index].is_saved_by_auth_count = 1;
                    this.posts[index].post_saved_count++;
                }
            } else if(action == 'inspire') {
                if (this.posts[index].is_inspired_by_auth_count == 1) {
                    this.posts[index].is_inspired_by_auth_count = 0;
                    this.posts[index].post_inspired_count--;
                } else {
                    this.posts[index].is_inspired_by_auth_count = 1;
                    this.posts[index].post_inspired_count++;
                }
            }

            // Prepare data for http request
            let data = {
                'post' : post,
                'action' : action
            };

            // Send http requests
            axios.post(url, data);
        },

        loadMore : function() {
            if(this.recordCount > 0) {
                this.isProcessing = true;
                let post_id = this.post_id;

                // console.log("data = ", this.data);
                // console.log("post_id = ", post_id);

                let url = this.url + '/api/post/search/' + post_id;

                // console.log(" url ", url);

                axios.post(url, this.data )
                    .then(function (response) {
                        this.isProcessing = false;

                        let offset = response.data.offset;
                        let posts = response.data.data.posts;
                        let count = response.data.count;

                        this.count = count;
                        this.data.offset = offset;
                        this.recordCount = (posts).length;

                        posts.forEach((contact) => {
                            this.posts.push(contact);
                        });

                    }.bind(this))
                    .catch(function (error) {
                        this.isProcessing = false;
                    });
            }
        },

        editOpen : function(index, post) {
            // console.log("edit open index ", index, ' post ', post);
            this.posts[index].edit = true;
        },

        editClose: function(index, post) {

            // console.log("edit close index ", index, ' post ', post);
            this.posts[index].edit = false;
        },

        editSubmit : function(index, post) {
            this.isProcessing = true;

            let url = this.url + '/api/post/'+ post.id + '/update';
            this.posts[index].isProcessingUpdate = true;

            axios.post(url, post)
                .then(function (response) {
                    this.posts[index].isProcessingUpdate = false;
                    this.isProcessing = false;

                    let post = response.data.data.post;

                    this.posts[index].title  = post.title;
                    this.posts[index].description = post.description;

                    this.posts[index].edit = false;
                }.bind(this))
                .catch(function (error) {
                    this.posts[index].isProcessingUpdate = false;
                    if (error.response.status === 422) {
                        this.posts[index].error = error.response.data.errors
                    }
                }.bind(this));
        },

        deleteSubmit : function(index, post) {
            if(confirm("Are you sure to delete this post?")) {
                this.isProcessing = true;

                let url = this.url + '/api/post/'+ post.id + '/delete';

                axios.post(url, post)
                    .then(function (response) {
                        this.isProcessing = false;

                        let post = response.data.data.post;

                        this.posts.splice(index, 1);
                    }.bind(this))
                    .catch(function (error) {
                        // @todo error to be added
                    });
            }
        },
    },
});