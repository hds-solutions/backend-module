<script src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('GOOGLE_MAPS_API') }}&ftype=.js"></script>
<script src="{{ asset(mix('backend-module/assets/js/app.js')) }}"></script>
<script src="{{ asset('backend-module/vendor/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend-module/vendor/tinymce/themes/silver/theme.min.js') }}"></script>
@stack('scripts')
