@extends('web.layout.master')

@section('content')

<section class="section wb">
    <div class="container py-5">
        <div class="row justify-content-center">

            <div class="col-lg-10">
                <div class="page-wrapper p-4 bg-white rounded shadow-sm">

                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ERROR MESSAGE --}}
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 pl-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">

                        <!-- ===== LEFT CONTENT ===== -->
                        <div class="col-lg-5 pr-lg-5 mb-4 mb-lg-0">
                            <h4 class="mb-3">Who we are</h4>
                            <p class="text-muted mb-4">
                                Tech Blog is a personal blog for handcrafted, camera-made photography content,
                                fashion styles from independent creatives around the world.
                            </p>

                            <h4 class="mb-3">How we help?</h4>
                            <p class="text-muted mb-4">
                                Contact us and we will help you resolve any questions about copyright,
                                images and content.
                            </p>

                            <h4 class="mb-3">Pre-Sale Question</h4>
                            <p class="text-muted">
                                Fusce dapibus nunc quis quam tempor vestibulum sit amet consequat enim.
                                Pellentesque blandit hendrerit placerat.
                            </p>
                        </div>

                        <!-- ===== RIGHT FORM ===== -->
                        <div class="col-lg-7 pl-lg-5">
                            <form class="form-wrapper" action="{{ route('web.contact.store') }}" method="post">
                                @csrf

                                <div class="form-group mb-3">
                                    <input type="text"
                                           name="name"
                                           class="form-control p-3"
                                           placeholder="Your name"
                                           value="{{ old('name') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email"
                                           name="address"
                                           class="form-control p-3"
                                           placeholder="Email address"
                                           value="{{ old('address') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text"
                                           name="phone"
                                           class="form-control p-3"
                                           placeholder="Phone"
                                           value="{{ old('phone') }}">
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text"
                                           name="subject"
                                           class="form-control p-3"
                                           placeholder="Subject"
                                           value="{{ old('subject') }}">
                                </div>

                                <div class="form-group mb-4">
                                    <textarea class="form-control p-3"
                                              name="message"
                                              rows="5"
                                              placeholder="Your message">{{ old('message') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary px-4 py-2">
                                    Send Message <i class="fa fa-envelope-open-o ml-1"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div><!-- end page-wrapper -->
            </div>

        </div>
    </div>
</section>

@endsection
