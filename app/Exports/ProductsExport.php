<?php
namespace App\Export;

use SCart\Core\Admin\Models\AdminProduct;

 use Maatwebsite\Excel\Concerns\FromCollection;


class ProductsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = ShopProduct::with('descriptions')->get()->toArray();
        $dataExport = [];
       /* foreach ($data as $key => $row) {
            $dataExport[$key]['sku'] = $row['sku'];
            $dataExport[$key]['name'] = $row['descriptions'][0]['name'];
            $dataExport[$key]['keyword'] = $row['descriptions'][0]['keyword'];
            $dataExport[$key]['description'] = $row['descriptions'][0]['description'];
            $dataExport[$key]['content'] = $row['descriptions'][0]['content'];
            $dataExport[$key]['price'] = $row['price'];
            $dataExport[$key]['price_promotion'] = $row['price_promotion'];
            $dataExport[$key]['date_start'] = $row['date_start'];
            $dataExport[$key]['date_end'] = $row['date_end'];
            $dataExport[$key]['status_promotion'] = $row['status_promotion'];
            $dataExport[$key]['kind'] = $row['kind'];
            $dataExport[$key]['status'] = $row['status'];
            $dataExport[$key]['image'] = $row['image'];
            $dataExport[$key]['images'] = $row['images'];
            $dataExport[$key]['category_id'] = $row['category_id'];
            $dataExport[$key]['brand_id'] = $row['brand_id'];
            $dataExport[$key]['supplier_id'] = $row['supplier_id'];
            $dataExport[$key]['viewed'] = $row['viewed'];
            $dataExport[$key]['sold'] = $row['sold'];
            $dataExport[$key]['download'] = $row['download'];
            $dataExport[$key]['downloaded'] = $row['downloaded'];
            $dataExport[$key]['sort'] = $row['sort'];
            $dataExport[$key]['created_at'] = $row['created_at'];
            $dataExport[$key]['updated_at'] = $row['updated_at'];
           $dataExport[$key]['nro_coutas'] = $row['nro_coutas'];
            $dataExport[$key]['cuotas_inmediatas'] = $row['cuotas_inmediatas'];
            $dataExport[$key]['monto_inicial'] = $row['monto_inicial'];
            $dataExport[$key]['id_modalidad_pagos'] = $row['id_modalidad_pagos'];

        }*/

        //Rerornar ccollection() de productos 
        

        return      $dataExport;
    }
}