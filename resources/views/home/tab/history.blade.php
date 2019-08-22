<div class="tab-history tab-pane fade {{ ($page == 'history') ? 'show active' : null }}" id="history" role="tabpanel" aria-labelledby="history-tab">
    <div  class="margin-top-15">
        <h5 class="card-title" :inner-html.prop="user.history_title">

        </h5>
        <p class="card-text">
            <span :inner-html.prop="user.history_description" ></span>

            @if(auth()->check())
                <a href="javascript:void(0)" class="login-only-show inline toggle-1 text-danger" v-if="editHistory == false" @click="editHistory=true" >Edit</a>
                <a href="javascript:void(0)" class="login-only-show inline toggle-1 text-danger" v-if="editHistory == true" @click="editHistory=false" >Close</a>
            @endif
        </p>
        @if(auth()->check())
            <form v-on:submit.prevent="profileUpdate('history')">
                <div class="login-only-show history-container-post" v-if="editHistory == true">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> History title</label>
                        <input type="text" class="form-control" value="My History" v-model="user.history_title">
                        <small id="emailHelp" class="form-text text-danger" v-if="errors.history_title"> @{{ errors.history_title[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">About your history</label>
                        <textarea class="form-control text-area " id="exampleFormControlTextarea1" rows="3" v-model="user.history_description" ></textarea>

                        <small id="emailHelp" class="form-text text-danger" v-if="errors.history_description"> @{{ errors.history_description[0] }}</small>

                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-danger" >Submit</button>
                    <div class="lds-ring sm absolute"  v-if="isProcessing == true">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
