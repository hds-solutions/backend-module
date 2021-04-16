@stack('config-scripts')
@stack('pre-scripts')
<script src="{{ asset(mix('backend-module/assets/js/app.js')) }}"></script>
<script src="{{ asset('backend-module/vendor/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend-module/vendor/tinymce/themes/silver/theme.min.js') }}"></script>
@stack('scripts')
