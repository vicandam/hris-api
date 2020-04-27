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
            user_id : 0,
            page : '',
            tab : '',
        },

        post : {
            title : '',
            description : '',
            type : 'text',
            video : '',
            photo : '',
            fd: '',
            ownerMore: '',
            more : '',
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

        isInteracting : false,

        videoFaileMessage : "",

        // PROFILE VARIABLES
        profile : {
            about : "",
        },
        aboutEditing : false,
        isSavingAbout : false,
        isProfilePictureUploading : false,
        isProfileLoading : false,
        isProfileSideBarReady : false,
        // /PROFILE VARIABLES
    },

    mounted() {
        this.loadMore();
        this.profileLoad();

        let search = window.search;
        let request_user_id = window.request_user_id;
        let tab = window.tab;


        if(tab) {
            this.data.tab = tab;
        }

        if(search) {
            this.data.keyword = search;
        }

        if(request_user_id) {
            this.data.request_user_id = request_user_id;
        }
    },

    methods: {
        // PROFILE
        fileOpen: function() {
            $('#imgInp').trigger('click');
        },

        aboutOpen() {
            this.aboutEditing = true;
        },

        aboutClose() {
            this.aboutEditing = false;
        },

        aboutSubmit() {
            this.isSavingAbout = true;
            this.errors = [];

            let url = this.url + '/api/profile/update/about';

            let data = this.profile;

            axios.post(url, data)
                .then(function (response) {

                    // let profile = response.data.data.profile;
                    //
                    // this.profile = profile;

                    this.isSavingAbout = false;
                    this.aboutEditing = false;
                }.bind(this))
                .catch(function (error) {
                    this.isSavingAbout = false;
                    // this.aboutEditing = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));



            // this.isSavingAbout = true;
            //
            // setTimeout(function(){
            //     this.isSavingAbout = false;
            //     this.aboutEditing = false;
            // }.bind(this), 2000)
            //

        },

        profileLoad() {
            this.isProfileLoading  = true;

            let url = this.url + '/api/profile/load';

            axios.post(url, this.data)
                .then(function (response) {
                    this.isProfileSideBarReady = true;
                    this.isProfileLoading  = false;

                    let profile = response.data.data.profile;

                    this.profile = profile;

                    $("#imgInp").val("");
                }.bind(this))
                .catch(function (error) {
                    this.isProfileLoading  = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },

        updatePhoto : function(event) {
            this.isProfilePictureUploading = true;
            this.errors = [];

            let url = this.url + '/api/profile/update/photo';

            let photo = event.target.files[0];

            const fd = new FormData();

            fd.append('photo', photo, photo.name);

            data = fd;

            axios.post(url, data)
                .then(function (response) {
                    this.isProfilePictureUploading = false;

                    let profile = response.data.data.profile;

                    this.profile = profile;
                }.bind(this))
                .catch(function (error) {
                    this.isChangeProfile = true;
                    this.isPostingImage = false;
                    this.isProfilePictureUploading = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },
        // /PROFILE

        // POST AND FEED
        postOpenFile : function() {
            $('#post-file-upload').trigger('click');
        },

        postType : function(type) {
            this.post.type = type;
            this.errors = [];

            if(type == 'photo' || type == 'video') {
                $('#post-description').attr('placeholder', 'Bless everyone with your positive words (optional)');
            } else {
                $('#post-description').attr('placeholder', 'Bless everyone with your positive words (required)');
            }
        },

        onFileSelected : function(event) {
            this.errors = [];

            this.post.photo = event.target.files[0];

            // // console.log(" photo ", this.post.photo);

            let output = document.getElementById('post-preview-photo');
            output.src = URL.createObjectURL(event.target.files[0]);
        },

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


        postSubmit : function() {
            this.isPosting = true;

            // this.isProcessing = true;

            // // console.log("Post 1 = ", this.post);

            let url = this.url + '/api/post/store';

            this.errors = [];

            let data = {};

            if(this.post.photo != null && this.post.type == 'photo') {
                // console.log("Photo");

                const fd = new FormData();

                fd.append('photo', this.post.photo, this.post.photo.name);
                fd.append('title', this.post.title);
                fd.append('description', this.post.description);
                fd.append('type', this.post.type);
                fd.append('video', this.post.video);

                data = fd;
            } else if(this.post.type == 'video') {

                this.videoExist = true;
                this.readingVideo = false;
                data = this.post;
            } else {
                data = this.post;
                // console.log("Video");
            }

            // // console.log(this.post);

            axios.post(url, data)
                .then(function (response) {
                    this.isPosting = false;
                    // this.isProcessing = false;

                    let post = response.data.data.post;
                    let posts = this.posts;

                    posts.unshift(post);
                    this.recordCount = (posts).length;
                    this.posts = posts;

                    // Clear all the fields
                    this.post.description = '';
                    this.post.title = '';
                    this.post.video= '';
                    this.post.photo= '';

                    $("#post-preview-photo").attr('src', this.url + '/img/default.png');
                    $("#imgInp").val("");
                }.bind(this))
                .catch(function (error) {
                    this.isChangeProfile = false;
                    this.isPostingImage = true;

                    this.isPosting = false;
                    // this.isProcessing = false;


                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));

        },

        loadMore : function() {
            if(this.recordCount > 0) {
                this.isProcessing = true;

                // // console.log("data = ", this.data);

                let url = this.url + '/api/post/search';

                this.data.page = 'profile';

                axios.post(url, this.data )
                    .then(function (response) {

                        // console.log(" finished in loading");

                        let tab = this.data.tab;

                        this.isProcessing = false;

                        let offset = response.data.offset;
                        let posts = response.data.data.posts;
                        let count = response.data.count;

                        // console.log(posts);

                        this.count = count;
                        this.data.offset = offset;
                        this.recordCount = (posts).length;

                        // console.log(" tab ", tab);
                        posts.forEach((post) => {

                            // The post is a child of the saved entry that's the reason why we just need the post and we call it a post.post and the first post is the  save entry and the second post is the post entry and we only get the second entry which is the real post
                            // console.log(" post ", post);
                            if(tab == 'saved' || tab == 'inspired') {
                                post = post.post;
                            }

                            // console.log(" push ", post);

                            this.posts.push(post);
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

        moreOpen : function(index, post) {
            this.isProcessing = true;

            let url = this.url + '/api/post/'+ post.id + '/view';

            //axios.post(url, post);

            // // console.log("more open index ", index, ' post ', post);

            // this.posts[index].more = true;
        },

        moreClose: function(index, post) {
            // console.log("more close index ", index, ' post ', post);

            this.posts[index].more = false;
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

        // POST AND FEED
    },

    watch: {
        'post.video' : function(newVal, oldVal) {

            let data = {'video' : newVal};

            let url = this.url + '/api/post/video/preview';

            if(newVal != null) {
                if(newVal.length > 10) {
                    this.errors = [];

                    this.isPosting = true;

                    axios.post(url, data)
                        .then(function (response) {
                            let videoEmbedded = response.data.data.video_embedded;
                            let videoExist = response.data.data.video_exist;

                            this.videoEmbedded = videoEmbedded;
                            this.videoExist = videoExist;
                            this.readingVideo = true;

                            this.isPosting = false;
                        }.bind(this));
                }
            }
        }
    },

    filters: {
        truncate : function(text, length, clamp){
            clamp = clamp || '...';
            let node = document.createElement('div');
            node.innerHTML = text;
            let content = node.textContent;
            return content.length > length ? content.slice(0, length) + clamp : content;
        },

        textMore: function (text, lenght) {
            let node = document.createElement('div');
            node.innerHTML = text;
            let content = node.textContent;
            return content.length > length ? content.slice(0, lenght) : content;
        },

        textLess: function (text, lenght) {
            let node = document.createElement('div');
            node.innerHTML = text;
            let content = node.textContent;
            return content.length > length ? content.slice(lenght, content.length) : "";
        },

        hasMore(text) {
        },
    }
});


// var loadFilePostFile = function(event) {
//     var output = document.getElementById('post-preview-photo');
//     output.src = URL.createObjectURL(event.target.files[0]);
// };
// var loadFileProfile = function(event) {
//     // var output = document.getElementById('profile-preview');
//     // output.src = URL.createObjectURL(event.target.files[0]);
// };
