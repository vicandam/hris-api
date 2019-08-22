new Vue({
    el: '#app',
    data: {
        isProcessing : true,
        account : {
            name : "",
            email : ""
        },
        errors : {},
        successMessage : '',
        url : window.url,
    },

    mounted() {
        this.load();
    },

    methods: {
        load : function() {
            this.isProcessing = true;
            this.isSuccess = false;

            let url = this.url + '/api/account/load';

            let data = this.account;

            axios.get(url, data)
                .then(function (response) {
                    this.isProcessing = false;

                    let account = response.data.data.account;

                    this.account = account;

                }.bind(this))
                .catch(function (error) {
                    this.isProcessing = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },

        updateSubmit : function() {
            this.errors = [];
            this.successMessage = '';
            this.isProcessing = true;

            let url = this.url + '/api/account/update';

            let data = this.account;

            axios.post(url, data)
                .then(function (response) {
                    this.isProcessing = false;

                    let account = response.data.data.account;
                    let successMessage = response.data.message;

                    this.account = account;
                    this.successMessage = successMessage;

                }.bind(this))
                .catch(function (error) {
                    this.isProcessing = false;

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                }.bind(this));
        },
    },
});
var loadFile = function(event) {
    var output = document.getElementById('post-preview-photo');
    output.src = URL.createObjectURL(event.target.files[0]);
};
