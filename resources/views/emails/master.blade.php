<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>@yield('title')</title>
    </head>
    <body style='font-family: Arial; font-size: 15px; width:600px; margin: 0 auto;'>
        <table border="0" cellpadding="0" cellspacing="0" width="600">

            <!-- header -->
            @include('emails.header')
            <!-- header -->

            <!-- body -->
            @yield('body')
            <!-- body -->

            <!-- footer -->
            @include('emails.footer')
            <!-- footer -->

        </table>
    </body>
</html>