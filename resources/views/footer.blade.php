
@if(session('success'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            iziToast.success({
                title: 'Success',
                message: '{{ session('success') ?? 'File uploaded' }}',
                position: 'bottomRight'
            });
        });
    </script>
@endif
@if(session('failed'))
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            iziToast.error({
                title: 'Error',
                message: '{{ session('failed') ?? 'File failed to upload' }}',
                position: 'bottomRight'
            });
        });
    </script>
    @endif
    </body>
    </html>
