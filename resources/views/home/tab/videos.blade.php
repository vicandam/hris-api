<div class="tab-video tab-pane fade {{ ($page == 'videos') ? 'show active' : null }}" id="video" role="tabpanel" aria-labelledby="video-tab">
    <div >
        @if(auth()->check())
            <div class="margin-top-15">
                <button class="btn btn-sm btn-outline-danger  toggle-1" v-if="addPortfolio==false" @click="addPortfolio=true" > Add Video </button>
                <button class="btn btn-sm btn-outline-danger  toggle-1" v-if="addPortfolio==true" @click="addPortfolio=false" > Close</button>
            </div>

            <!-- The container of the form fields-->
            <form v-on:submit.prevent="postSubmit('video', 'store')" >
                <div class="login-only-show portfolio-container-post" v-if="addPortfolio == true" >
                    <div class="form-group">
                        <label for="exampleInputEmail1">Youtube Url</label> <br>
                        <input type="text" aria-describedby="emailHelp"  class="form-control" v-model="post.video" >
                        <small id="emailHelp" class="form-text text-danger" v-if="errors.video"> @{{ errors.video[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  v-model="post.title" >
                        <small id="emailHelp" class="form-text text-danger" v-if="errors.title"> @{{ errors.title[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Project description</label>
                        <textarea class="form-control text-area" id="exampleFormControlTextarea1" rows="3" v-model="post.description" ></textarea>
                        <small id="emailHelp" class="form-text text-danger" v-if="errors.description"> @{{ errors.description[0] }}</small>
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-danger">Submit</button>
                    <div class="lds-ring sm absolute"  v-if="isPosting == true">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </form>
    @endif

    <!-- Display all the videos here -->
        <ul class="list-group question-and-answer-container" >
            <li class="list-group-item"  v-for="(post1, index) in posts" >
                <div class="question-container" >
                    <div class="row">
                        <div class="col-md-4" style="text-align: center">
                            <iframe width="100%" height="215"  v-bind:src="post1.embededUrl" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">
                                <a target="_blank" v-bind:href="post1.video">
                                    @{{ post1.title }}
                                </a>
                            </h5>

                            <p class="card-text" :inner-html.prop="post1.description"  > </p>

                            {{--<button class="btn btn-sm btn-outline-danger login-only-show toggle-1">Edit</button>--}}

                            @if(auth()->check())
                                <form v-on:submit.prevent="postSubmit('video', 'update', index)" >

                                    <div style="height: 28px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1 edit-post" @click="posts[index].editing=true" v-if="posts[index].editing == false" >Edit</button>
                                        <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1 edit-post " @click="posts[index].editing=false" v-if="posts[index].editing == true" >Close</button>

                                        <span v-if="posts[index].editing == false">
                                                                <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1" @click="postDelete(post1, index)"  v-if="posts[index].deleting == false" >Delete</button>
                                                                <div v-else class="lds-ring sm absolute">
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                    <div></div>
                                                                </div>
                                                            </span>
                                    </div>

                                    <div class="login-only-show toggle-2" v-if="posts[index].editing == true">
                                        <hr>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Title</label>
                                            <input type="text" value="This is the text" class="form-control" v-model="post1.title" >
                                            <small id="emailHelp" class="form-text text-danger" v-if="post1.error.title"> @{{ post1.error.title[0] }}</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Description</label>
                                            <textarea class="form-control text-area" v-model="post1.description" ></textarea>
                                            <small id="emailHelp" class="form-text text-danger" v-if="post1.error.description"> @{{ post1.error.description[0] }}</small>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-outline-danger"  >Update</button>
                                        <div class="lds-ring sm absolute" v-if="posts[index].loader == true">
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
                </div>
            </li>
        </ul>

        <div class="no-result-found" v-if="posts.length < 1 && isProcessing == false">

            No result found.

        </div>


        <!-- Load more videos -->
        <div class="pull-center load-more-container" v-if="recordCount > 0" >
            <div class="lds-ring sm absolute" v-if="isProcessing == true">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <button v-else type="button" class="btn btn-outline-primary" @click="load('video')"   >
                            <span >
                                Load more
                            </span>
                <i  v-else class="fa fa-spinner" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
