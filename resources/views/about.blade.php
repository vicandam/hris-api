@extends('layouts.app')

@section('content')
    <div class="container-fluid account-container " >
        <div >
            <div class="row">
                <div class="col-md-3 page-left-container" >
                    <a class="nav-link" href="{{ route('privacy-policy') }}">
                        Privacy Policy
                    </a>
                    <a class="nav-link active" href="{{ route('about') }}">
                        About
                    </a>
                    <a class="nav-link" href="{{ route('terms') }}">
                        Terms
                    </a>
                </div>
                <div class="col-md-6 page-center-container"  >
                    <!-- Textarea with icon prefix -->
                    <div class="card text-center body-content ">
                        <div class="account-title-container">
                            <h4> About </h4>

                        </div>

                        <div class="post-content-header">
                            <div class="card-body post-content-body"  >

                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                <br>
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                <br>
                                <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection