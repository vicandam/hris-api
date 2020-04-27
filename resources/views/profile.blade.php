@extends('layouts.app')

@section('content')

    <div class="container-fluid profile-container"  v-cloak >
        <div >
            <div class="row">
                <!-- left sidebar container -->
                    <div  class="col-md-3 page-left-container" >
                        <div v-if="isProfileSideBarReady == true" >

                            <div class="profile-picture-container"  v-cloak >

                                <img @click="fileOpen" id="profile-preview" class="media-object profile-preview   " v-bind:class="{'profile-uploading-image' : isProfilePictureUploading == true}"  v-bind:src="profile.photo"  >
                            </div>
                            <div v-if="errors.photo && isChangeProfile == true" class="error-container">
                                <span class="red text-center">
                                    @{{  errors.photo[0] }}
                                </span>
                            </div>


                            @if(auth()->check() && auth()->user()->id == $request_user_id)
                                <div  class="file-container">
                                    <form id="form1" runat="server">
                                        <input  type='file' id="imgInp" accept="image/*" onchange="loadFileProfile(event)" @change="updatePhoto"
                                        />
                                    </form>
                                </div>
                            @endif

                            <a class="nav-link name"  href="#">
                                <h4>
                                    @{{ profile.name }}
                                </h4>
                            </a>
                            <p v-if="profile.about.length > 1" >
                                @{{ profile.about }}

                                @if(auth()->check() && auth()->user()->id == $request_user_id)
                                    <span v-if="aboutEditing == false">
                                        <span class="badge badge-primary edit-button"  style="cursor: pointer"  data-value="edit" @click="aboutOpen"  >
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            Edit
                                        </span>
                                    </span>
                                @endif
                            </p>

                            <div v-if="errors.about" class="error-container no-margin">
                                <span class="red text-center">
                                    @{{  errors.about[0] }}
                                </span>
                            </div>

                            <div class="margin-bottom-1"> </div>

                            <div v-if="aboutEditing == true">
                                <textarea  class="about-textarea" v-model="profile.about">@{{ profile.about }}</textarea>

                                <div class="margin-bottom-1"> </div>

                                <span class="counter-container" >
                                     <span class="not-allowed" v-bind:class="{'not-allowed' : profile.about.length < 10,'allowed' : profile.about.length > 10 && profile.about.length <= 200}" >@{{ profile.about.length }}</span> / 200
                                  </span>

                                <div class="form-group">

                                    <button type="button" class="btn btn-sm btn-danger cancel-button"   data-value="cancel" @click="aboutClose" >Cancel</button>
                                    <button type="button" class="btn btn-sm btn-primary"  @click="aboutSubmit" >Update</button>

                                    <div class="lds-ring sm left-and-right-side-of-button" v-if="isSavingAbout" >
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-sparator" >

                            <div class="height-1"> </div>

                            <!-- Sidebar container -->
                                <a class="nav-link " href="{{ route('home') }}" >Happy Life (Home)</a>
                                <a class="nav-link {{ ( ($tab == 'posts' || $tab == '') ? 'active' : null ) }}" href="{{ route('profile', [$user->id, $user->slug]) }}?tab=posts" >Posts ( {{ $user->posts_count }} )</a>
                                <a class="nav-link {{ ($tab == 'saved' ? 'active' : null ) }}" href="{{ route('profile', [$user->id, $user->slug]) }}?tab=saved" >Saved ( {{ $user->post_saved_count }} )</a>
                                <a class="nav-link {{ ($tab == 'inspired' ? 'active' : null ) }}" href="{{ route('profile', [$user->id, $user->slug]) }}?tab=inspired" >Inspired ( {{ $user->post_inspired_count }} )</a>

                            <div class="height-1"> </div>
                            <div class="height-1"> </div>
                        </div>
                        <div v-else class="load-container" >
                        </div>
                    </div>

                    <!-- center container -->
                    <div class="col-md-6 page-center-container" v-cloak >
                    @if(auth()->check() && auth()->user()->id == $request_user_id)
                        <!-- Post container -->
                            <form v-on:submit.prevent="postSubmit" >
                                <div class="form-group post-container" >
                                    <textarea id="post-description" class="form-control post-textarea" placeholder="Bless everyone with your positive words (required)" v-model="post.description" ></textarea>

                                    <div class="margin-bottom-1"> </div>

                                    <span class="counter-container" >
                                        <span v-if="post.type == 'text'" class="not-allowed" v-bind:class="{'not-allowed' : post.description.length < 10,'allowed' : post.description.length >= 10 && post.description.length <= 1000}" >@{{ post.description.length }}</span> <span v-else v-bind:class="{'not-allowed' : post.description.length > 1000,'allowed' : post.description.length <= 1000}">@{{ post.description.length }}</span> / 1000
                                     </span>

                                    <div v-if="errors.description" class="error-container">
                                        <span class="red text-center">
                                            @{{  errors.description[0] }}
                                        </span>
                                    </div>

                                    <div class="card-footer text-muted photo-container" v-if="post.type == 'photo'">
                                        <div>
                                            <label>

                                                {{ trans('paragraph.post_image_message_title') }}
                                            </label>
                                        </div>

                                        <form id="form1" runat="server">
                                            <input  type='file' id="post-file-upload" accept="image/*" onchange="loadFilePostFile(event)" @change="onFileSelected" />
                                        </form>

                                        <div class="margin-bottom-1"> </div>

                                        <div class="post-preview-photo-container">
                                            <img @click="postOpenFile" id="post-preview-photo" class="mr-3 img-preview" v-bind:src="'{{$url}}' + '/img/default.png'" alt="Generic placeholder image" name="photo" v-model="post.photo" >
                                        </div>

                                        <div v-if="errors.photo" class="error-container">
                                            <span class="red text-center">
                                                @{{  errors.photo[0] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-footer text-muted video-container" v-if="post.type == 'video'" >

                                        <label>
                                            {{ trans('paragraph.post_video_message_title') }}
                                        </label>
                                        <input type="text" id="video" class="form-control"   name="video" placeholder="{{ trans('paragraph.post_video_message_field_placeholder') }}" v-model="post.video" >

                                        <div v-if="errors.video" class="error-container">
                                            <span class="red text-center">
                                                @{{  errors.video[0] }}
                                            </span>
                                        </div>

                                        <div class="height-1"> </div>

                                        <div>
                                            <div v-if="videoExist == true && readingVideo == true" >
                                                <center>
                                                    <iframe id="ytplayer" type="text/html" class="embed-responsive-item"   v-bind:src="videoEmbedded" allowfullscreen   frameborder="0" ></iframe>
                                                </center>
                                            </div>
                                            <div v-else-if="videoExist == false && readingVideo == true" class="error-container" >
                                                {{ trans('paragraph.post_video_message_error') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group post-option-container" >
                                        <label class="radio-inline"><input type="radio" name="optradio" value="text"  v-on:click="postType('text')" checked> Only Text </label> &nbsp;
                                        <label class="radio-inline"><input type="radio" name="optradio" value="with photo"
                                                                           v-on:click="postType('photo')" > With photo </label> &nbsp;
                                        <label class="radio-inline"><input type="radio" name="optradio" value="with video"  v-on:click="postType('video')" > With video </label> &nbsp;
                                    </div>

                                    <hr class="border-sparator"  >

                                    <div class="margin-bottom-1"> </div>

                                    <div  class="post-submit-container" >
                                        <button type="submit" class="btn btn-outline-primary" v-bind:disabled="isPosting">Post</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /Post container -->
                        @elseif(! auth()->check())
                            <div class="card text-center post-content-container unauthenticated">
                                <div class="no-result-found-container"  >
                                    <h4>
                                        {!! trans('paragraph.ask_to_login') !!}
                                    </h4>
                                </div>
                            </div>
                        @endif

                    <div class="load-container" v-if="isPosting == true && isProcessing == false" >
                        <div class="lds-ring">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <!-- /Post container -->

                    <div v-infinite-scroll="loadMore"
                         infinite-scroll-disabled="isProcessing"
                         infinite-scroll-distance="2000"
                         infinite-scroll-immediate-check="true" >
                        <div v-for="(post, index) in posts" :key="index" v-cloak >

                            <!-- / Start of main posted modal -->
                            <div class="card text-center post-content-container">
                                <div class="post-content-header">
                                    <div class="media">
                                        <a v-bind:href=" '{{ $url }}' + '/' + post.owner.id + '/' + post.owner.slug">
                                            <img class="mr-3" v-bind:src="post.owner.photo" alt="Generic placeholder image" >
                                        </a>
                                        <div class="media-body" >
                                            <h5 class="mt-0 post-owner-name" >
                                                <a v-bind:href="'{{ $url }}' + '/' + post.owner.id + '/' + post.owner.slug">
                                                    @{{ post.owner.name }}
                                                </a>
                                            </h5>
                                            <p class="member-about" >
                                                @{{ post.owner.about |  textMore(100) }}<span v-if="post.owner.more == true" >@{{ post.owner.about |  textLess(100) }}</span><small data-value="more" class="btn-more-less " @click="posts[index].owner.more = true" v-if="post.owner.more== false && post.owner.about.length > 100"   >..more</small><small data-value="less" class="btn-more-less" @click="posts[index].owner.more = false" v-if="post.owner.more == true" > ..less </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}

                                <div class="card-body post-content-body"  >
                                    <!-- Edit container -->
                                    <div v-if="posts[index].edit == true"  class="edit-container">
                                        <textarea class="form-control post-textarea" placeholder="Bless everyone with your positive words." v-model="posts[index].description"></textarea>

                                        <div v-if="posts[index].error.description[0] != null" class="error-container">
                                            <span class="red text-center">
                                                @{{  posts[index].error.description[0] }}
                                            </span>
                                        </div>

                                        <div class="margin-bottom-1"> </div>

                                        <span class="counter-container" >
                                            <span v-if="post.type == 'text'" class="not-allowed" v-bind:class="{'not-allowed' : post.description.length < 10,'allowed' : post.description.length >= 10 && post.description.length <= 1000}" >@{{ post.description.length }}</span> <span v-else v-bind:class="{'not-allowed' : post.description.length > 1000,'allowed' : post.description.length <= 1000}">@{{ post.description.length }}</span> / 1000
                                        </span>

                                        <div class="margin-bottom-1"> </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger cancel-button" data-value="cancel" @click="editClose(index, post)" >Cancel</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" @click="editSubmit(index, post)" >Update</button>

                                        <div class="lds-ring sm left-and-right-side-of-button" v-if="posts[index].isProcessingUpdate == true" >
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <!-- /Edit container -->

                                    <p class="card-text post-description" v-if="post.description != null">
                                           @{{ post.description  |  textMore(200) }}<span v-if="posts[index].more == true" >@{{ post.description  |  textLess(200) }}</span><small data-value="more" class="btn-more-less " @click="posts[index].more = true;moreOpen(index, post)" v-if="
                                            posts[index].more == false && post.description.length > 200"  >.. more</small><small data-value="less" class="btn-more-less" @click="posts[index].more = false" v-if="posts[index].more == true" >..less</small>


                                         @if(auth()->check())
                                            <div v-if="post.owner.id == '{{ auth()->user()->id}}' && posts[index].edit == false" class="post-edit-option">
                                                    <span>
                                                        <span class="badge badge-primary edit-button btn-edit-delete" v-bind:data-id="post.id" data-value="edit" @click="posts[index].edit = true" title="Edit this post" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</span>
                                                    </span>

                                                <span  class="label lable-danger btn-edit-delete">
                                                           <span class="badge badge-danger" @click="deleteSubmit(index, post)"  title="Delete this post" >
                                                               <i class="fa fa-trash" aria-hidden="true"></i>
                                                               Delete
                                                           </span>
                                                     </span>
                                            </div>
                                         @endif
                                     </p>
                                     <div class="margin-bottom-1" v-if="post.type != 'text'"> </div>

                                    <div class="post-image-video-container">
                                        <iframe v-if="post.type == 'video'" id="ytplayer" type="text/html"
                                                v-bind:src="post.embededUrl" frameborder="0"></iframe>
                                        <img v-if="post.type == 'photo' && post.photo != null" v-bind:src="post.photo" class="img-fluid" alt="Inspiration Image">
                                    </div>
                                </div>



                                <div class="card-footer post-content-footer text-muted" >
                                    <span>
                                        <span>
                                              <i class="fa fa-eye" aria-hidden="true"></i>
                                              Views (@{{ post.total_view }})
                                        </span>
                                    </span>

                                    @if(auth()->check())
                                        <span @click="interaction(post, index, 'save')" >
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                            <span v-if="posts[index].is_saved_by_auth_count == 1">Unsave (@{{ posts[index].post_saved_count }})</span>
                                            <span v-else>Save (@{{ posts[index].post_saved_count }})</span>
                                        </span>
                                        <span @click="interaction(post, index, 'inspire')" >
                                            <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                            <span v-if="posts[index].is_inspired_by_auth_count == 1">Uninspired (@{{ posts[index].post_inspired_count }})</span>
                                            <span v-else>Inspired (@{{ posts[index].post_inspired_count }})</span>
                                        </span>
                                    @else
                                        <a href="{{ route('login') }}">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                            <span>Saved (@{{ posts[index].post_saved_count }})</span>
                                        </a>
                                        <a href="{{ route('login') }}">
                                            <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                            <span>Inspired (@{{ posts[index].post_inspired_count }})</span>
                                        </a>
                                    @endif

                                    <span class="view-detail-link">
                                        <span>
                                            <a v-bind:href="'{{ $url }}/post/' + post.id + '/' + post.slug">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                {{--<i class="fa fa-pencil-square-o" aria-hidden="true"></i>--}}
                                                Visit
                                            </a>
                                        </span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- /Post container -->

                    <div class="card text-center post-content-container " v-if="count == 0 && ! isProcessing && posts.length < 1" >
                        <div class="no-result-found-container"  >
                            <h4>
                                No result found
                            </h4>
                        </div>
                    </div>

                    <!-- Loader -->
                    <div class="pull-center load-more-container"   >
                        <div v-if="isProcessing" class="load-container" >
                            <div class="lds-ring">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" v-on:click="loadMore" v-if="count > limit && recordCount > 0 && ! isProcessing" >
                                        <span v-if="!isProcessing">
                                            Load more
                                        </span>
                            <i  v-else class="fa fa-spinner" aria-hidden="true"></i>
                        </button>
                    </div>
                    <!-- / Loader -->
                </div>
                <!-- /Sidebar container -->

                <!-- right side container -->
                <div class="col-md-3 page-right-container"  >
                    @foreach(trans('paragraph.ads') as $ads)
                        <div class="card"  >
                            @if($ads['image'])
                                <img class="card-img-top" src="{{ $ads['image'] }}" alt="Card image cap">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title">{!! $ads['title'] !!} </h5>
                                <p class="card-text">
                                    {!! $ads['message'] !!}
                                </p>
                            </div>
                        </div>

                        <div class="height-1"> </div>
                        <div class="height-1"> </div>
                    @endforeach
                </div>
                <!-- /right side container -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/profile.js') }}"></script>
@endpush

