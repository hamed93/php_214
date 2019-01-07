@extends('Home.master')


@section('content')
    <!-- Blog Post Content Column -->
    <div class="col-lg-8">

        <!-- Blog Post -->

        <!-- Title -->
        <h1>{{ $course->title }}</h1>

        <!-- Author -->
        <p class="lead small">
            توسط <a href="#">{{ $course->user->name }}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p><span class="glyphicon glyphicon-time"></span> ارسال شده در ۱۲ خرداد ۹۶</p>

        <hr>
       <!-- for playing viedo with video js -->
        <video id="my-video" class="video-js" controls preload="auto" width="640" height="264"
               poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
            <source src="{{ \App\Episode::find(1)->download() }}" type='video/mp4'>
            <p class="vjs-no-js">
                To view this video please enable JavaScript, and consider upgrading to a web browser that
                <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
            </p>
        </video>
        <!-- Post Content -->
       <div id="content">
           {!! $course->body !!}
       </div>
        <hr>

        @if(auth()->check())
           @if($course->type == 'vip')
                @if(! user()->isActive())
                    <div class="alert alert-danger" role="alert">برای مشاهده تمامی قسمت ها باید عضویت ویژه تهیه کنید</div>
                @endif
           @elseif($course->type == 'cash')
               @if(! user()->checkLearning($course))
                    <div class="alert alert-danger" role="alert">برای مشاهده تمامی قسمت ها باید این دوره را خریداری کنید</div>
                @endif
           @endif
        @else
            <div class="alert alert-danger" role="alert">برای مشاهده این دوره نیاز است ابتدا وارد سایت شوید</div>
        @endif

        <h3>قسمت های دوره</h3>
        <table class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>شماره قسمت</th>
                    <th>عنوان قسمت</th>
                    <th>زمان قسمت</th>
                    <th>دانلود</th>
                </tr>
            </thead>
            <tbody>
                @foreach($course->episodes()->latest()->get() as $episode)
                    <tr>
                        <th>{{ $episode->number }}</th>
                        <td>{{ $episode->title }}</td>
                        <td>{{ $episode->time }}</td>
                        <td>
                            <a href="{{ $episode->download() }}"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody> </table>
        <!-- Blog Comments -->

        @include('Home.layouts.comment' , ['comments' => $comments , 'subject' => $course])
    </div>

    <!-- Blog Sidebar Widgets Column -->

        <div class="col-md-4">
            {{--@if(! auth()->user()->checkLearning($course))--}}
                 {{--<div class="well">--}}
                    {{--برای استفاده از این دوره نیاز است این دوره را با مبلغ ۱۰۰۰۰ تومان خریداری کنید--}}
                    {{--<form action="/course/payment" method="post">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<input type="hidden" name="course_id" value="{{ $course->id }}">--}}
                        {{--<button type="submit" class="btn btn-success">خرید دوره</button>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--@endif--}}

        @if(auth()->check())
            @if($course->type == 'vip')
                @if(! user()->isActive())
                    <div class="well"><a href="{{ route('user.panel.vip') }}">برای مشاهده تمامی قسمت ها باید عضویت ویژه تهیه کنید</a></div>
                @endif
            @elseif($course->type == 'cash')
                @if(! user()->checkLearning($course))
                        <div class="well">
                            برای استفاده از این دوره نیاز است این دوره را با مبلغ ۱۰۰۰۰ تومان خریداری کنید
                            <form action="/course/payment" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-success">خرید دوره</button>
                            </form>
                        </div>
                @endif
            @endif
        @else
            <div class="well">برای مشاهده این دوره نیاز است ابتدا وارد سایت شوید</div>
        @endif
        <!-- Blog Search Well -->
        <div class="well">
            <h4>جستجو در سایت</h4>
            <div class="input-group">
                <input type="text" class="form-control">
                <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
            </div>
            <!-- /.input-group -->
        </div>

        <!-- Side Widget Well -->
        <div class="well">
            <h4>دیوار</h4>
            <p>طراح گرافیک از این متن به عنوان عنصری از ترکیب بندی برای پر کردن صفحه و ارایه اولیه شکل ظاهری و کلی طرح سفارش گرفته شده استفاده می نماید، تا از نظر گرافیکی نشانگر چگونگی نوع و اندازه فونت و ظاهر متن باشد.</p>
        </div>

    </div>

@endsection