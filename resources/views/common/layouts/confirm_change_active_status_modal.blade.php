<div class="fade modal modal-confirm-post" id="modal_confirm_change_active_status" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('common.title_modal_delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="text-center">
                   <p>{{ trans('common.change_active_place') }}</p>
                </div>
            </div>
            <!-- Modal footer -->
            <form id="change_active_status" method="POST">
                @csrf
                @method('POST')
                <div class="modal-footer text-center d-block">
                    <button type="button" class="btn btn-secondary waves-effect mw-160 mx-3" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                    <button type="submit" class="btn btn-danger btn-confirm mw-160 mx-3">{{ trans('common.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>


