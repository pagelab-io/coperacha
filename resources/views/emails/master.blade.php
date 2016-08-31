<center>
    <div style='font-family: Arial; font-size: 15px; width:600px; margin: 0 auto;'>
        <table border="0" cellpadding="0" cellspacing="0" width="600">

            <!-- header -->
            @include('emails.header')
            <!-- header -->

            <!-- body -->
            <tr>
                <td style="padding: 15px 10px" colspan="2">
                    <table width="100%">
                        @yield('body')
                    </table>
                </td>
            </tr>
            <!-- body -->

            <!-- footer -->
            @include('emails.footer')
            <!-- footer -->

        </table>
    </div>
</center>
