<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleCSVExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            trans('qrcode.name'),
            trans('qrcode.postcode_1'),
            trans('qrcode.postcode_2'),
            trans('qrcode.address'),
            trans('qrcode.tel'),
            trans('qrcode.birthday'),
            trans('qrcode.sex'),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $sampleData = collect([
                                ["サイキ ハンスケ", "060", "8588", "札幌市中央区北3条西6丁目", "011-231-4111", "1980/12/10", "M"],
                                ["クロタ ミノブ", "030", "8570", "青森市長島一丁目1-1", "017-722-1111", "1983/01/02", "M"],
                                ["ウエハラ ヨシヒロ", "980", "8570", "盛岡市内丸10番1号", "019-651-3111", "1981/09/28", "F"],
                                ["ワタナベ ノゾミ", "980", "8570", "仙台市青葉区本町3丁目8番1号", "022-211-2111", "1989/04/10", "M"],
                                ["ババ マサヒロ", "010", "8570", "秋田市山王四丁目１－１", "018-860-1111", "2000/10/20", "F"],
                            ]);
        return $sampleData;
    }
}
