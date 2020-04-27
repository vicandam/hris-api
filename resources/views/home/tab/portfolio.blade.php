<div class="tab-portfolio tab-pane fade {{ ($page == 'portfolio') ? 'show active' : null }}" id="portfolio" role="tabpanel" aria-labelledby="portfolio-tab">

    @if(auth()->check())
        <div class="margin-top-15">
            <button class="btn btn-sm btn-outline-danger  toggle-1" v-if="addPortfolio==false" @click="addPortfolio=true" > Add Portfolio </button>
            <button class="btn btn-sm btn-outline-danger  toggle-1" v-if="addPortfolio==true" @click="addPortfolio=false" > Close</button>
        </div>

        <!-- The container of the form fields-->
        <form v-on:submit.prevent="postSubmit('portfolio', 'store')" >
            <div class="login-only-show portfolio-container-post" v-if="addPortfolio == true" >
                <div class="form-group">
                    <label for="exampleInputEmail1">Url</label> <br>
                    <input type="text" aria-describedby="emailHelp"  class="form-control" v-model="post.url" >
                    <small id="emailHelp" class="form-text text-danger" v-if="errors.url"> @{{ errors.url[0] }}</small>
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
                <div class="form-group">
                    <label for="exampleInputEmail1">Photo</label> <br>
                    <input type="file" class="portfolio-file-field" aria-describedby="emailHelp" id="portfolio-file-field" @change="onFileSelected" >
                    <small id="emailHelp" class="form-text text-danger" v-if="errors.photo"> @{{ errors.photo[0] }}</small>
                </div>
                <div class="form-group">
                    <img
                        @click="fileOpen('#portfolio-file-field')"
                        class="card-img-top profolio-image-preview"
                        id="post-preview-photo"
                        src="{{ url('/') }}/img/default.png"
                        alt="Card image cap"
                        id=""
                    >
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

    <div class="card-columns margin-top-15">
        <div class="card" v-for="(post1, index) in posts">
            <a target="_blank" v-bind:href="post1.url">
                <img class="card-img-top" v-bind:src="post1.photo" alt="Porfolio Image">
            </a>

            <div class="card-body">
                <h5 class="card-title">
                    <a target="_blank" v-bind:href="post1.url">
                        @{{ post1.title }}
                    </a>
                </h5>
                <p class="card-text">@{{ post1.description }}</p>
                @if(auth()->check())
                    <form v-on:submit.prevent="postSubmit('portfolio', 'update', index)" >

                        <div style="height: 28px;">
                            <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1 edit-post" @click="posts[index].editing=true" v-if="posts[index].editing == false" >Edit</button>
                            <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1 edit-post " @click="posts[index].editing=false" v-if="posts[index].editing == true" >Close</button>
                            <button type="button" class="btn btn-sm btn-outline-danger login-only-show toggle-1" @click="postDelete(post1, index)"  v-if="posts[index].deleting == false" >Delete</button>
                            <div v-else class="lds-ring sm absolute">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <div class="login-only-show toggle-2" v-if="posts[index].editing == true">
                            <hr>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Url</label>
                                <input type="text" value="" class="form-control" v-model="post1.url" >
                                <small id="emailHelp" class="form-text text-danger" v-if="post1.error.url"> @{{ post1.error.url[0] }}</small>
                            </div>
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

    <div class="no-result-found" v-if="posts.length < 1 && isProcessing == false">

        No result found.

    </div>

    <div class="pull-center load-more-container" v-if="recordCount > 0" >
        <div class="lds-ring sm absolute" v-if="isProcessing == true">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <button v-else type="button" class="btn btn-outline-primary" @click="load('portfolio')"   >
                                <span >
                                    Load more
                                </span>
            <i  v-else class="fa fa-spinner" aria-hidden="true"></i>
        </button>
    </div>
</div>
