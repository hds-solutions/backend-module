<div class="modal fade" id="foreign-modal" tabindex="-1" role="dialog"
    aria-labelledby="foreign-modal-title" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-{{ request()->has('only-form') ? 'xxl' : 'xl' }} modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header align-items-center">
                <h5 class="modal-title flex-grow-1" id="foreign-modal-title">Modal title</h5>

                <div class="modal-controls">
                    <i class="ml-2 far fa-window-maximize" data-maximize="modal"></i>
                    <i class="ml-2 far fa-window-restore" data-restore="modal"></i>
                    <i class="ml-2 far fa-window-close" data-dismiss="modal"></i>
                </div>
            </div>

            <div class="modal-body {{ request()->has('only-form') ? 'xh-90vh' : 'xh-75vh' }} p-0">
                <iframe src="" class="w-100 h-100 border-0"></iframe>
                <div class="backdrop"></div>
            </div>

        </div>
    </div>

</div>
@if (request()->has('only-form'))
<script type="text/javascript">
    window.parent.postMessage({
        ready: true
    }, window.parent.location);
</script>
@endif
