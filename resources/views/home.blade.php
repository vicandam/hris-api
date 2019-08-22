@extends('layouts.app')
@section('content')
    <div class="container container-sub" v-cloak >
        <div class="row">
            <div class="col-md-3 profile-picture-container" >
                <div class="media profile-picture-container-sub"  >
                    <div class="media-left media-top" >
                        <img @click="fileOpen('#imgInp')" id="profile-preview" class="media-object profile-preview" v-bind:class="{'profile-uploading-image' : isProfilePictureUploading == true}"  v-bind:src="user.photo"  >
                    </div>
                </div>
                @if(auth()->user())
                    <div class="margin-top-15 profile-file-container login-only-show" >
                        <input  type='file' id="imgInp" accept="image/*" @change="updatePhoto" />
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <h5> <b> @{{ user.name }} </b></h5>
                <h6> <b> @{{ user.position }} </b></h6>
                <p>
                    <span :inner-html.prop="user.about" ></span>
                    @if(auth()->check())
                        <a href="javascript:void(0)"  class="login-only-show inline text-danger"  @click="editAbout=true" v-if="editAbout==false" > edit </a>
                        <a href="javascript:void(0)"  class="login-only-show inline text-danger"  @click="editAbout=false" v-if="editAbout==true" > close </a>
                    @endif
                </p>
                @if(auth()->check())

                    <form v-on:submit.prevent="profileUpdate('basic information')" >

                        <div class="login-only-show about-container-post margin-top-15"  v-if="editAbout==true" >
                            <div class="form-group">
                                <label for="exampleInputEmail1">Full Name</label>
                                <input type="text" value="" class="form-control" v-model="user.name" >
                                <small id="emailHelp" class="form-text text-danger" v-if="errors.name">@{{ errors.name[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Position</label>
                                <input type="text" value="" class="form-control" v-model="user.position" >
                                <small id="emailHelp" class="form-text text-danger" v-if="errors.position">@{{ errors.position[0] }}</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Write something more about you.</label>
                                <textarea class="form-control text-area" id="exampleFormControlTextarea1" v-model="user.about" rows="3"> </textarea>
                                <small id="emailHelp" class="form-text text-danger" v-if="errors.about">@{{ errors.position[0] }}</small>
                            </div>
                            <button type="submit" class="btn btn-sm btn-outline-danger" >Submit</button>
                            <div class="lds-ring sm absolute" v-if="isProcessing == true">
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

        {{--<hr>--}}

        <div class="row no-margin-top" >
            <div class="col-md-12">
                <ul class="nav nav-tabs tab-container-ul" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'feed-stackoverflow' || $page == 'feed-github-repository') ? 'active' : null }}" id="feed-tab" data-toggle="tab" href="#feed" role="tab" aria-controls="feed" aria-selected="true" @click="navigateTab('feed', 'stackoverflow')" >
                            FEED
                            <br>
                            <small>
                                Communities activity
                            </small>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'portfolio') ? 'active' : null }}" id="portfolio-tab" data-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false" @click="navigateTab('portfolio')" >
                            PORTFOLIO
                            <br>
                            <small>
                                Checkout my products
                            </small>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'history') ? 'active' : null }} " id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="false" @click="navigateTab('history')" >
                            HISTORY
                            <br>
                            <small>
                                Know more about me
                            </small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'contact') ? 'active' : null }}"
                           id="contact-tab"
                           data-toggle="tab"
                           href="#contact"
                           role="tab"
                           aria-controls="contact"
                           aria-selected="false"
                           @click="navigateTab('contact')" >
                            CONTACT ME
                            <br>
                            <small>
                                Get a Quote
                            </small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'videos') ? 'active' : null }} " id="video-tab" data-toggle="tab" href="#video" role="tab" aria-controls="video" aria-selected="false" @click="navigateTab('videos')" >
                            VIDEOS
                            <br>
                            <small>
                                My videos
                            </small>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($page == 'feedback') ? 'active' : null }} " id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false" @click="navigateTab('feedback')" >
                            FEEDBACK
                            <br>
                            <small>
                                Post feedback
                            </small>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    {{--FEED--}}
                    @include('home.tab.feed')

                    {{--PORTFOLIO--}}
                    @include('home.tab.portfolio')

                    {{--HISTORY--}}
                    @include('home.tab.history')

                    {{--CONTACT--}}
                    @include('home.tab.contact')

                    <!-- VIDEOS -->
                    @include('home.tab.videos')

                    <!-- FEEDBACK -->
                    @include('home.tab.feedback')

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/home.js') }}"></script>
@endpush
