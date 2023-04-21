<div class="fade modal modal-confirm-delete" id="modal_confirm_delete">
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
                   <p>{{ trans('common.message_delete') }}</p>
                   <p>{{ trans('common.message_delete_confirm') }}</p>
                </div>
            </div>
            <!-- Modal footer -->
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer text-center d-block">
                    <button type="button" class="btn btn-secondary waves-effect mw-160 mx-3" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                    <button type="submit" class="btn btn-danger btn-confirm mw-160 mx-3">{{ trans('common.confirm_modal') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
