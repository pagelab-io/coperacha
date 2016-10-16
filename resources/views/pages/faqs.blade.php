@extends("layouts.content")

@section("page-content")

    <!-- Faqs Layout -->
    <section class="content-body faqs-layout">
        <div class="holder">
            <div class="container-fluid">
                <div class="content">
                    <!-- Faqs -->
                    <div class="faqs">
                        @foreach($childrens as $faq)
                            <div class="faq">
                                <div class="question clearfix">
                                    <span class="text">{{$faq->post_title}}</span>
                                    <span class="icon"></span>
                                </div>
                                <div class="answer">
                                    <div class="inner">
                                        {!! $faq->post_content !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection