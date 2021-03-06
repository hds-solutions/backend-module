<script type="text/javascript">
    window.opener.postMessage({
        namespace: '{{ Str::pluralStudly(strtolower(class_basename(get_class($resource)))) }}',
        resource: {!! json_encode($resource) !!},
        saved: {!! $resource->exists !!},
    }, window.opener.location);
</script>