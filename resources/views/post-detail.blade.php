@extends('layouts.app')

@section('content')
    <div class="container-fluid"   >
        <div >
            <div class="row">
                <!-- Sidebar container -->
                <div class="col-md-3 page-left-container"   >
                    <a class="nav-link active " href="{{ route('home') }}" >Happy Life (Home)</a>
                </div>

                <div class="height-1"> </div>

                <!-- /Sidebar container -->

                <!-- right side container -->
                <div class="col-md-6 page-center-container" v-cloak >
                    <div v-for="(post, index) in posts" :key="index" v-cloak >

                    <!-- / Start of main posted modal -->
                            <div class="card text-center post-content-container post-detail-page" >
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
                                                @{{ post.owner.about |  textMore(100) }}<span v-if="post.owner.more == true" >@{{ post.owner.about |  textLess(100) }}</span><small data-value="more" class="btn-more-less " @click="posts[index].owner.more = true" v-if="post.owner.more== false && post.owner.about.length > 100"   >.. more</small><small data-value="less" class="btn-more-less" @click="posts[index].owner.more = false" v-if="post.owner.more == true" > less..</small>
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
                                            @{{ post.description }}
                                            @if(auth()->check())
                                                <div v-if="post.owner.id == '{{ auth()->user()->id}}' && posts[index].edit == false" class="post-edit-option">
                                                    <span>
                                                        <span class="badge badge-primary edit-button btn-edit-delete" v-bind:data-id="post.id" data-value="edit" @click="posts[index].edit = true" title="Edit this post" >
                                                           <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit
                                                        </span>
                                                    </span>
                                                    <span  class="label lable-danger btn-edit-delete"  >
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
                                                    v-bind:src="post.embededUrl" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
                                            <img v-if="post.type == 'photo' && post.photo != null" v-bind:src="post.photo" class="img-fluid" alt="Inspiration Image">
                                        </div>
                                </div>


                                <div class="card-footer post-content-footer text-muted" >
                                    <span>
                                        <span>
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            {{--<i class="fa fa-pencil-square-o" aria-hidden="true"></i>--}}
                                            Views (@{{ post.total_view }})
                                        </span>
                                    </span>

                                    @if(auth()->check())
                                        <span @click="interaction(post, index, 'save')" >
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                            {{--<i class="fa fa-pencil-square-o" aria-hidden="true"></i>--}}
                                            <span v-if="posts[index].is_saved_by_auth_count == 1">Unsave (@{{ posts[index].post_saved_count }})</span>
                                            <span v-else>Save (@{{ posts[index].post_saved_count }})</span>
                                        </span>
                                        <span @click="interaction(post, index, 'inspire')" >
                                           <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                            {{--<i class="fa fa-pencil-square-o" aria-hidden="true"></i>--}}
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
                                                Visit
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- /Post container -->
                    </div>

                <!-- /right side container -->

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
    <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/post-detail.js') }}"></script>
@endpush