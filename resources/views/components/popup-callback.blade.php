<!DOCTYPE html>
<html>
<head>
    <title>callback</title>
</head>
<body>
    <script type="text/javascript">
        window.parent.postMessage({
            namespace: '{{ Str::snake( Str::pluralStudly( class_basename($resource) ) ) }}',
            resource: { id: {{ $resource->getKey() ?? 'null' }} },
            saved: {{ $resource->exists ? 'true' : 'false' }},
        }, window.parent.location);
    </script>
</body>
</html>
