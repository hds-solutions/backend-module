<!DOCTYPE html>
<html>
<head>
    <title>callback</title>
</head>
<body>
    <script type="text/javascript">
        window.opener.postMessage({
            namespace: '{{ Str::snake( Str::pluralStudly( class_basename($resource) ) ) }}',
            resource: {!! json_encode($resource) !!},
            saved: {{ $resource->exists ? 'true' : 'false' }},
        }, window.opener.location);
    </script>
</body>
</html>
