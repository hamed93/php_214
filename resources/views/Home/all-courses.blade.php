@extends('Home.master')

@section('content')

    <form action="/courses">
        <div class="form-group col-md-3">
            <select name="type" class="form-control">
                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>همه دوره ها</option>
                <option value="vip" {{ request('type') == "vip" ? 'selected' : '' }}>اعضای ویژه</option>
                <option value="cash" {{ request('type') == "cash" ? 'selected' : '' }}>نقدی</option>
                <option value="free" {{ request('type') == "free"  ? 'selected' : '' }}>رایگان</option>
            </select>
        </div>

        <div class="form-group col-md-3">
            <select name="category" class="form-control">
                <option value="all">همه دسته ها</option>
                @foreach(\App\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label class="checkbox-inline">
                <input type="checkbox" name="order" value="1" {{ request('order') == '1' ? 'checked'  : ''}}>از اول به آخر
            </label>
        </div>

        <div class="form-group col-md-3">
            <button class="btn btn-danger" type="submit">فیلتر</button>
        </div>
    </form>

    <hr>
    <div class="row">
        <div class="col-lg-12">
            <h3>آخرین دوره ها</h3>
        </div>
    </div>
    <div class="row ">

        @foreach($courses as $course)
            <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{{ $course->images['thumb'] }}" alt="">
                    <div class="caption">
                        <h3><a href="{{ $course->path() }}">{{ $course->title }}</a></h3>
                        <p>{{ str_limit($course->description , 120) }}</p>
                        <p>
                            <a href="{{ $course->path()  }}" class="btn btn-primary">خرید</a> <a href="{{ $course->path()  }}" class="btn btn-default">اطلاعات بیشتر</a>
                        </p>
                    </div>
                    <div class="ratings">
                        <p class="pull-left">{{ $course->viewCount }} بازدید</p>
                        <p class="pull-left">{{  Redis::get("views.{$course->id}.courses") }} بازدید</p>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    {!! $courses->appends(['type' => request('type') , 'order' => request('order') , 'category' => request('category')])->render() !!}
@endsection