<div class="fade modal modal-show-note" id="modal_show_note">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-0">
                <h4 id="name_place" class="custom-text-long width-350"></h4>
                <button type="button" class="close pt-4" data-dismiss="modal">&times;</button>
            </div>
            <div id="body_note" class="modal-body">
                <div class="row">
                    <input id="no-data" type="hidden" value="{{ trans('shortage-supplies.empty') }}">
                    <div class="col-12">
                        <label class="font-weight-bold">{{ trans('shortage-supplies.note') }}</label>
                        <textarea
                            id="content-comment"
                            class="form-control"
                            rows="5"
                            readonly
                            ></textarea>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label class="font-weight-bold"> {{ trans('shortage-supplies.comment') }}</label>
                        <textarea
                            id="content-note"
                            class="form-control"
                            rows="5"
                            readonly
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
