new Vue({
    el: '#app',
    data: {
        isProfilePictureUploading : false,
        isProcessing : true,
        isProcessingFeed : true,
        url : '',
        editAbout : false,
        addFeedback: false,
        addPortfolio: false,
        editHistory : false,
        editReceiverContact : false,
        isSendingContact : false,
        isPostingFeedback : false,
        isPosting : false,
        page : false,
        offset :0,
        limit:5,
        portfolio : {
            photo : '',
        },
        feeds : [],
        feedbacks : [  ],
        user : {},
        message : {
            section : '',
            type : '',
            message : '',
            subject : '',
            project_name : '',
            email : '',
            skype_id : '',
            name : '',
            category : 'Select category',
            hours : 0,
            days : 0,
            weeks : 0,
            months : 0
        },
        post : {
            url : '',
            description : '',
            photo : '',
            video : '',
            type : 'photo',
            title: '',
            section: '',
            action: ''
        },
        posts : [
            {
                url : '',
                description : '',
                photo : '',
                video : '',
                type : 'photo',
                title: '',
                section: '',
                action: '',
                error: ''
            }
        ],
        errors : [],
        tab : 'feed',
        subtab: 'feed-stackoverflow',
        recordCount : 1,

        timeInput : {
            weekly : 40, // this is the total hours in a weekly
            monthly : 160, // this is the total hours in a month
            hourly: 30, // this is the rate and I am expensive, I need to rate my self as expensive because I am and I am who I am. They only pay how much you think you are worth.
            daily : 8, // this is the hours

            products : {
                productCostHours: 0,
                productDays: 0,
                productWeeks: 0,
                productMonths: 0,
            },

            hours : {
                productTotalHours: 0,
                productTotalHoursDays: 0,
                productTotalHoursWeeks: 0,
                productTotalHoursMonths: 0
            },

            total : {
                payable:0 ,
                productPhp:0 ,
                downpayment:0 ,
            }
        },
        payable : 0,
        productPhp : 0,
        downPayment : 0,
        totalHoursOverall : 0
    },

    computed: {

        totalPayable: function () {
            let hours = this.message.hours;
            let days = this.message.days;
            let weeks = this.message.weeks;
            let months = this.message.months;

            let hourly = this.timeInput.hourly;
            let daily = this.timeInput.daily;
            let weekly = this.timeInput.weekly;
            let monthly = this.timeInput.monthly;

            // total payable calculation
            let productCostHours = hours * hourly;
            let productCostDays = (days * daily) * hourly;
            let productCostWeeks = (weeks * weekly) * hourly;
            let productCostMonths = (months * monthly) * hourly;

            // total hours calculations
            let productTotalHoursDays = days * daily;
            let productTotalHoursWeeks = weeks * weekly;
            let productTotalHoursMonths = months * monthly;


            let sum = 0 ;

            // get total overall hours
            let totalHoursOverall = parseInt(hours) + parseInt(productTotalHoursDays) + parseInt(productTotalHoursWeeks) + parseInt(productTotalHoursMonths);
            totalHoursOverall = (totalHoursOverall).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            this.totalHoursOverall = totalHoursOverall;

            // total payable calculation
            this.timeInput.productCostHours = productCostHours;
            this.timeInput.productDays = productCostDays;
            this.timeInput.productWeeks = productCostWeeks;
            this.timeInput.productMonths = productCostMonths;

            // total hours calculations, used to save in database
            this.timeInput.hours.productTotalHoursDays = productTotalHoursDays;
            this.timeInput.hours.productTotalHoursWeeks = productTotalHoursWeeks;
            this.timeInput.hours.productTotalHoursMonths = productTotalHoursMonths;

            // save the hours, days, month and week
            this.timeInput.hours.productTotalHours = parseInt(hours);
            this.timeInput.days = parseInt(days);
            this.timeInput.weeks = parseInt(weeks);
            this.timeInput.months = parseInt(months);

            if(productCostHours > 0) {
                sum = sum + productCostHours;
            }
            if(productCostDays > 0) {
                sum = sum + productCostDays;
            }
            if(productCostWeeks > 0) {
                sum = sum + productCostWeeks;
            }
            if(productCostMonths > 0) {
                sum = sum + productCostMonths;
            }

            this.payable = sum;

            // store total payable
            this.timeInput.total.payable = sum;

            payable = (sum).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            return payable;
        },

        totalPayableInPhp : function() {

            let phpToUsd = 50;
            let payable = this.payable;

            let productPhp = payable * phpToUsd;

            this.productPhp = productPhp;

            this.timeInput.total.productPhp = productPhp;

            productPhp = (productPhp).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');


            return productPhp;
        },

        totalDownpayment : function() {
            let downPayment = 0;
            let payable = this.payable;

            downPayment = payable / 2;

            this.downPayment = downPayment;

            // store total downpayment
            this.timeInput.total.downpayment = downPayment;

            downPayment = (downPayment).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            return downPayment;
        },
    },

    mounted() {
        this.url = window.url;

        let tab = this.tab;

        let subtab = '';

        this.load();

        this.page = window.page;

        if(this.page == 'feed-stackoverflow' || this.page == '') {
            tab = 'feed';
            subtab = 'stackoverflow';
        } else if(this.page == 'feed-github-repository') {

            tab = 'feed';
            subtab = 'github-repository';

        } else {
            tab = this.page;
        }

        this.navigateTab(tab, subtab);
    },

    methods: {
        onFileSelected : function(event) {
            this.errors = [];

            this.post.photo = event.target.files[0];

            let output = document.getElementById('post-preview-photo');

            output.src = URL.createObjectURL(event.target.files[0]);
        },
        navigateTab : function(tab, subtab) {
            this.recordCount = 1;

            this.limit = 10;
            this.offset = 0;

            if (tab == 'feedback') {
                this.feedbacks = [];
            } else if (tab == 'portfolio') {
                this.posts = [];
            } else if (tab == 'feed') {
                this.limit = 10;
                this.offset = 1;

                this.feeds = [];

                this.subtab = subtab;
            } else if (tab == 'video') {
                this.posts = [];
            } else {

            }

            this.posts = [];

            this.load(tab, subtab);

            this.changeUrl(tab, subtab);

        },

        changeUrl: function(tab, subtab) {
            let url = '';
            let title = '';

            if(tab) {
                url = tab;
                title = tab;
            }

            if(subtab) {
                url = url + '-' + subtab;
                title = " | " + title + ' | ' + subtab;
            }

            document.title = 'Vic Datu Andam ' + title;

            history.replaceState({}, '', url);

        },
        sendMessage : function(section) {
            this.errors = [];

            let url = this.url + '/api/message1/contact1';

            let data = this.message;

            data.section = section;

            if(data.section == 'contact') {
                data.type = 'contact'
                this.isSendingContact = true;

                data.others = this.timeInput;
            } else if(data.section == 'post feedback') {
                data.type = 'feedback'
                this.isPostingFeedback = true;
            } else {
                this.isProcessing = true;
            }

            axios.post(url, data)
                .then(function (response) {
                    this.isProcessing = false;
                    this.isSendingContact = false;
                    this.isPostingFeedback = false;

                    this.editAbout = false;
                    this.editHistory = false;
                    this.editReceiverContact = false;
                    this.addFeedback = false;

                    this.message.message = '';
                    this.message.subject = '';
                    this.message.project_name = '';
                    this.message.email = '';
                    this.message.skype_id = '';
                    this.message.name = '';

                    // clear the hours
                    this.message.hours = 0;
                    this.message.days = 0;
                    this.message.weeks = 0;
                    this.message.months = 0;

                    this.message.category = 'Select category';

                    if(data.section == 'contact') {
                        alert("Thank you for sending me contact and a quote, I am excited to work with you and will get back to you as soon as possible.");
                    }else if(data.section == 'post feedback') {
                        let feedback = response.data.data.feedback;
                        // this.posts.push(message);
                        this.feedbacks.unshift(feedback);
                        alert("Thank you for posting your feedback, I really appreciate it.");
                    }
                }.bind(this))
                .catch(function (error) {
                    this.isProcessing = false;
                    this.isSendingContact = false;
                    this.isPostingFeedback = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },
        fileOpen: function(fileId) {
            $(fileId).trigger('click');
        },
        updatePhoto : function(event) {
            this.isProfilePictureUploading = true;
            this.errors = [];

            let url = this.url + '/api/user/profile/update/photo';

            let photo = event.target.files[0];

            const fd = new FormData();

            fd.append('photo', photo, photo.name);
            fd.append('section', 'profile photo');

            data = fd;

            axios.post(url, data)
                .then(function (response) {
                    this.isProfilePictureUploading = false;

                    let user = response.data.data.user;

                    this.user = user;
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
        profileUpdate : function(section) {
            this.errors = [];

            let url = this.url + '/api/user/profile/update';

            this.isProcessing = true;

            let data = this.user;

            data.section = section;

            axios.post(url, data)
                .then(function (response) {
                    this.isProcessing = false;

                    this.editAbout = false;
                    this.editHistory = false;
                    this.editReceiverContact = false;
                }.bind(this))
                .catch(function (error) {
                    this.isProcessing = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },
        postSubmit : function(section, action='', index=0) {
            this.isPosting = true;

            let url = '';

            this.errors = [];

            let data = {};

            if(action == 'update') {
                let id = this.posts[index].id;

                url = this.url + '/api/post/ ' + id + ' /update';

                data = this.posts[index];

                data.action = 'update';
                data.section = section; //'portfolio';

                this.posts[index].loader = true;
            } else {
                url = this.url + '/api/post/store';
            }

            this.post.action = action;
            this.post.section = section;

            if(action != 'update') {

                if (section == 'video') {
                    this.videoExist = true;
                    this.readingVideo = false;

                    data = this.post;

                    data.type = 'video';
                } else if (this.post.photo != null && this.post.type == 'photo') {
                    const fd = new FormData();

                    fd.append('photo', this.post.photo, this.post.photo.name);
                    fd.append('title', this.post.title);
                    fd.append('description', this.post.description);
                    fd.append('type', this.post.type);
                    fd.append('video', this.post.video);
                    fd.append('section', this.post.section);
                    fd.append('action', this.post.action);
                    fd.append('url', this.post.url);

                    data = fd;
                } else {
                    data = this.post;
                }
            }

            axios.post(url, data)
                .then(function (response) {


                    let url = this.url;
                    this.isPosting = false;
                    // this.isProcessing = false;

                    // this.recordCount = (posts).length;

                    // Clear all the fields
                    this.post.video = '';
                    this.post.url = '';
                    this.post.description = '';
                    this.post.title = '';
                    // this.post.video= '';
                    // this.post.photo= '';

                    $("#post-preview-photo").attr('src', url + '/img/default.png');
                    $("#portfolio-file-field").val("");

                    if((section == 'video' || section == 'portfolio') && action == 'store') {

                        let post = response.data.data.post;

                        this.posts.unshift(post);

                        this.addPortfolio = false;
                    }


                    // update the video and stop the loading and close the edit formds
                    if(section == 'video' && action == 'update') {
                        this.posts[index].loader = false;
                        this.posts[index].editing = false;
                    }

                    // update the portfolio and stop the loading and close the edit formds

                    if(section == 'portfolio' && action == 'update') {

                        this.posts[index].editing = false;
                        this.posts[index].loader = false;
                    }

                }.bind(this))
                .catch(function (error) {

                    // this.isPosting = false;
                    // this.isProcessing = false;


                    if(section == 'portfolio' && action == 'update') {

                        this.posts[index].editing = true;
                        this.posts[index].loader = false;
                    } else {
                        this.isPosting = false;

                    }



                    if (error.response.status === 422) {
                        let errors = error.response.data.errors

                        if(action == 'update') {
                            this.posts[index].error = errors;
                        } else {
                            this.errors = errors;
                        }
                    }
                }.bind(this));

        },
        postDelete : function(post, index) {
            if(confirm("Are you sure to delete this post?")) {
                // this.isProcessing = true;

                let url = this.url + '/api/post/'+ post.id + '/delete';

                this.posts[index].deleting = true;

                axios.post(url, post)
                    .then(function (response) {
                        // this.isProcessing = false;

                        let post = response.data.data.post;

                        this.posts.splice(index, 1);


                        this.posts[index].deleting = false;
                    }.bind(this))
                    .catch(function (error) {
                        // @todo error to be added
                    });
            }
        },
        load : function(tab, subtab) {
            this.isProcessing = true;

            let url = '';
            let data = {};

            if(tab == 'videos') {
                tab ='video';
            }

            if(tab == 'feedback') {
                url = this.url + '/api/message/feedback/search';

                data = {
                    'offset' : this.offset,
                    'limit' : this.limit,
                    'type' : 'feedback'
                }
            } else if(tab == 'portfolio') {
                url = this.url + '/api/post/search';

                data = {
                    'offset' : this.offset,
                    'limit' : this.limit,
                    'type' : 'photo'
                }
            } else if(tab == 'video') {
                url = this.url + '/api/post/search';

                data = {
                    'offset' : this.offset,
                    'limit' : this.limit,
                    'type' : 'video'
                }
            } else if (tab == 'feed') {
                subtab = this.subtab;

                if(subtab == 'stackoverflow') {
                    this.isProcessingFeed = true;
                    url = this.url + '/api/external/stackoverflow-question-and-answer';

                    let offset = this.offset;

                    if (offset == 0) {
                        this.offset = 1;
                    }

                    data = {
                        'offset': this.offset,
                        'limit': this.limit
                    }
                } else if (subtab == 'github-repository') {
                    this.isProcessingFeed = true;
                    url = this.url + '/api/external/git/repositories';

                    let offset = this.offset;

                    data = {
                        'offset' : this.offset,
                        'limit' : this.limit
                    }
                }
            } else {
                url = this.url + '/api/user/profile/load';
                data = this.data;
            }

            axios.post(url, data)
                .then(function (response) {
                    this.isProcessing = false;

                    let user = response.data.data.user;

                    let offset = response.data.offset;
                    let limit = response.data.limit;

                    this.offset = offset;
                    this.limit = limit;

                    if(tab == 'feedback') {
                        let feedbacks = response.data.data.feedbacks;

                        this.recordCount = feedbacks.length;

                        feedbacks.forEach((feedback) => {
                            this.feedbacks.push(feedback);
                        });
                    } else if(tab == 'portfolio') {
                        let posts = response.data.data.posts;

                        this.recordCount = posts.length;

                        posts.forEach((post) => {
                            this.posts.push(post);
                        });

                    } else if(tab == 'video') {
                        let posts = response.data.data.posts;

                        this.recordCount = posts.length;

                        posts.forEach((post) => {
                            this.posts.push(post);
                        });

                    } else if (tab == 'feed' && subtab == 'stackoverflow') {
                        let feeds = response.data.data.question_and_answer;
                        this.isProcessingFeed = false;

                        this.recordCount = feeds.length;

                        feeds.forEach((feed) => {
                            this.feeds.push(feed);
                        });
                    } else if (tab == 'feed' && subtab == 'github-repository') {

                        let feeds = response.data.data.repositories;
                        this.isProcessingFeed = false;

                        this.recordCount = feeds.length;

                        feeds.forEach((feed) => {
                            this.feeds.push(feed);
                        });

                    } else {
                        this.user = user;
                    }
                }.bind(this))
                .catch(function (error) {
                    this.isProcessing = false;
                    if (tab == 'feed' && subtab == 'stackoverflow') {
                        this.isProcessingFeed = false;
                    }


                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        }
    },

    filters: {
        convertToAgo: function (value) {
            let d = new Date(value);

            return d.getFullYear() + '/' + d.getDay() + '/' + d.getDate();
        },
    }
});
