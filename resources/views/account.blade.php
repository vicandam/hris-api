@extends('layouts.app')

@section('content')
    <div class="container-fluid account-container " v-cloak >
        <div >
            <div class="row">
                <div class="col-md-3 page-left-container" >
                    <a class="nav-link active" href="{{ route('account') }}">
                        Basic Information
                    </a>
                    <a class="nav-link" href="{{ route('change-password') }}">
                        Change Password
                    </a>
                </div>
                    <div class="col-md-6 page-center-container"  >
                        <!-- Textarea with icon prefix -->
                        <div class="card text-center body-content ">
                            <div class="account-title-container">
                                <h4> Basic Information</h4>

                                {!! trans('paragraph.change_account_description') !!}
                            </div>

                            <div class="post-content-header">

                                <div class="success-container"  v-if="successMessage != ''" >
                                    <span class="green text-center">
                                        @{{ successMessage }}
                                    </span>
                                </div>

                                <form v-on:submit.prevent="updateSubmit">
                                    <div class="card-body post-content-body"  >

                                    <div class="form-group">
                                        <label class="label label-default" >
                                            Your Name:
                                        </label>
                                        <input type="text" placeholder="Full Name" class="form-control"  v-model="account.name" />

                                        <div v-if="errors.name" class="error-container">
                                            <span class="red text-center">
                                                @{{  errors.name[0] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="label label-default" >
                                            Your Email:
                                        </label>
                                        <input type="text" placeholder="Email" class="form-control" v-model="account.email" v-bind:disabled="true" />

                                        <div v-if="errors.email" class="error-container">
                                            <span class="red text-center">
                                                @{{  errors.email[0] }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-primary" > Update </button>

                                        <div class="lds-ring sm left-and-right-side-of-button" v-if="isProcessing">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset( $environmentParentFolderAssetJsCompiledPages . '/account.js') }}"></script>
@endpush

