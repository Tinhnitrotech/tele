<div class="table-responsive mb-3 mt-3">
        <table class="table table-bordered table-striped dt-responsive mb-2 text-center">
            <thead class="table-head">
            <tr class="row-header">
                <th class="m-w-160" >{{ trans('admin_refuge_detail.place_name') }}</th>
                <th class="m-w-160">{{ trans('admin_refuge_detail.join_in') }}</th>
                <th class="m-w-160">{{ trans('admin_refuge_detail.join_out') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(count($history) > 0)
                @foreach($history as $item)
                    <tr data-widget="expandable-table"
                        aria-expanded="false">
                        <td>
                            <span class="custom-text-long width-200">
                            {{ getTextChangeLanguage($item[0]['placeName'], $item[0]['placeNameEn']) }}
                            </span>
                        </td>
                        <td>
                            {{ isset($item[0]['access_datetime']) && $item[0]['access_datetime'] ?  date('Y/m/d H:i',strtotime($item[0]['access_datetime'])) :'-' }}
                        </td>
                        <td>
                            {{ isset($item[1]['access_datetime']) && $item[1]['access_datetime']  ?date('Y/m/d H:i', strtotime($item[1]['access_datetime'])) : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    @if(count($history) > 0)
        {{ $history->render('common.layouts.pagination') }}
    @endif
