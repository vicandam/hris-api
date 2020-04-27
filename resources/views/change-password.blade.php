    @extends('layouts.app')

@section('content')
    <div class="container-fluid account-container " v-cloak >
        <div >
            <div class="row">
                <div class="col-md-3 page-left-container" >
                    <a class="nav-link" href="{{ route('account') }}">
                        Basic Information
                    </a>
                    <a class="nav-link active" href="{{ route('change-password') }}">
                        Change Password
                    </a>
                </div>
                    <div class="col-md-6 page-center-container"  >
                        <!-- Textarea with icon prefix -->
                        <div class="card text-center  body-content">
                            <div class="account-title-container">
                                <h4>Change your password</h4>
                                {!! trans('paragraph.change_password_description') !!}
                            </div>

                            <div class="post-content-header">
                                <div class="success-container"  v-if="successMessage != ''" >
                                    <span class="green text-center">
                                        @{{ successMessage }}
                                    </span>
                                </div>

                                <div v-if="errors.password" class="error-container">
                                    <span class="red text-center">
                                        @{{  errors.password[0] }}
                                    </span>
                                </div>
                                <form v-on:submit.prevent="updateSubmit">
                                    <div class="card-body post-content-body"  >

                                    <div class="form-group">
                                        <label class="label label-default" >
                                            Password:
                                        </label>
                                        <input type="password" placeholder="Password" class="form-control"  v-model="account.password"  />
                                    </div>

                                    <div class="form-group">
                                        <label class="label label-default" >
                                            Password:
                                        </label>
                                        <input type="password" placeholder="Confirm Password" class="form-control" v-model="account.password_confirmation" value=""/>
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
    <script src="{{ asset($environmentParentFolderAssetJsCompiledPages . '/change-password.js') }}"></script>
@endpush

