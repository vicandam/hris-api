<div class="tab-feedback tab-pane fade {{ ($page == 'feedback') ? 'show active' : null }}" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
    <div  class="margin-top-15">
        <button class="btn btn-sm btn-outline-danger toggle-1" v-if="addFeedback == false" @click="addFeedback=true" > Add Feedback </button>
        <button class="btn btn-sm btn-outline-danger toggle-1" v-if="addFeedback == true" @click="addFeedback=false" > Close </button>
    </div>

    <form v-on:submit.prevent="sendMessage('post feedback')" >
        <div class="toggle-2 feedback-container-post" v-if="addFeedback == true" >
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="message.email" >
                <small id="emailHelp" class="form-text text-danger" v-if="errors.email"> @{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="message.name" >
                <small id="emailHelp" class="form-text text-danger" v-if="errors.name"> @{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Project name</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model="message.project_name" >

                <small id="emailHelp" class="form-text text-danger" v-if="errors.project_name"> @{{ errors.project_name[0] }}</small>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Submit feedback</label>
                <textarea class="form-control text-area" id="exampleFormControlTextarea1" rows="3" v-model="message.message"></textarea>
                <small id="emailHelp" class="form-text text-danger" v-if="errors.message"> @{{ errors.message[0] }}</small>
            </div>
            <button type="submit" class="btn btn-sm btn-outline-danger">Submit</button>
            <div class="lds-ring sm absolute" v-if="isPostingFeedback == true">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </form>
    <div class=" margin-top-15" >
        <a href="javascript:void(0)" v-for="feedback in feedbacks" class="no-border-radius list-group-item list-group-item-action flex-column align-items-start"  >
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                    <img v-bind:src="feedback.avatar" class="feedback-avatar" />

                    @{{ feedback.name }}
                    <br>
                    <small>
                        <b>
                            <em>
                                @{{ feedback.project_name}}
                            </em>
                        </b>
                    </small>
                </h5>
            </div>
            <p class="mb-1">@{{ feedback.message }}</p>
        </a>

        <div class="no-result-found" v-if="feedbacks.length < 1 && isProcessing == false">

            No result found.

        </div>

        <div class="pull-center load-more-container" v-if="recordCount > 0">
            <div class="lds-ring sm absolute" v-if="isProcessing == true">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <button v-else type="button" class="btn btn-outline-danger" @click="load('feedback')" >
                                    <span >
                                        Load more
                                    </span>
            </button>
        </div>
    </div>
</div>
