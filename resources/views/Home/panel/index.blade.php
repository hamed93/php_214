@component('Home.panel.master')

    <ul style="margin: 20px">
        <li>نام کاربری : {{ auth()->user()->name }}</li>
        <li>ایمیل کاربری : {{ auth()->user()->email }}</li>
         @if(user()->isActive())
             <li> زمان پایان اعتبار ویژه : 20 روز دیگر</li>
         @else
            <li>شما عضو ویژه نیستید</li>
        @endif
    </ul>

@endcomponent
