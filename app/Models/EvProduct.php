<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvProduct extends Model
{
    protected $table = "ev_product";

    protected $fillable = ['id', 'name', 'description', 'parent_id', 'type', 'detailed_description', 'created_at',
        'updated_at', 'deleted_at', 'json'];

    // type: (primary_product, delivery_product, addon_product)

    public static function getById($id){

        $query = self::select();
        return $query->where('id', $id)
            ->first();
    }

    public static function addProductsFromEv($param){

//        pd($param,'$param');

        $insert = [];

//        pd($insert,'$insert');
//        p($deliveryRelToAddon,'$deliveryRelToAddon');

        try {
            \DB::beginTransaction();
            // database queries here
            /** primary_product */
            foreach($param AS $key => $ppItem){
                $insert[$ppItem['productID']] = [
                    'id' =>  $ppItem['productID'],
                    'name' =>  $ppItem['name'],
                    'description' =>  $ppItem['description'],
                    'parent_id' =>  0,
                    'type' =>  'primary_product',
                    'detailed_description' =>  $ppItem['DetailedDescription'],
                    'json' =>  json_encode($ppItem),
                    'created_at' =>  date('Y-m-d H:i:s')
                ];

                //<editor-fold desc="delivery_product">
                foreach($ppItem['deliveryProducts'] AS $key => $dpItem){
                    $insert[$dpItem['productID']] = [
                        'id' =>  $dpItem['productID'],
                        'name' =>  $dpItem['name'],
                        'description' =>  $dpItem['description'],
                        'parent_id' =>  $ppItem['productID'],
                        'type' =>  'delivery_product',
                        'detailed_description' =>  $dpItem['DetailedDescription'],
                        'created_at' =>  date('Y-m-d H:i:s'),
                        'json' =>  json_encode($dpItem),
                    ];

                    /*p([
                        'primary_product_id' => $ppItem['productID'],
                        'delivery_product_id' => $dpItem['productID'],
                    ],'primary_product_id--'.'delivery_product_id');*/

                    $res = EvPrimaryDeliveryProduct::firstOrCreate([
                        'primary_product_id' => $ppItem['productID'],
                        'delivery_product_id' => $dpItem['productID'],
                    ],[
                        'created_at' =>  date('Y-m-d H:i:s')
                    ]);

//                    p($res->toArray(),'$res');

                }
                //</editor-fold>

                //<editor-fold desc="addon_product">
                foreach($ppItem['addOnProducts'] AS $key => $apItem){
                    $insert[$apItem['productID']] = [
                        'id' =>  $apItem['productID'],
                        'name' =>  $apItem['name'],
                        'description' =>  $apItem['description'],
                        'parent_id' =>  0,
                        'type' =>  'addon_product',
                        'detailed_description' =>  $apItem['DetailedDescription'],
                        'created_at' =>  date('Y-m-d H:i:s'),
                        'json' =>  json_encode($apItem),
                    ];

                    foreach ($apItem['deliveryProductIds'] AS $idsKey => $idsItem){
                        EvDeliveryAddonProduct::firstOrCreate([
                            'delivery_product_id' => $idsItem,
                            'addon_id' => $apItem['productID'],
                        ],[
                            'created_at' =>  date('Y-m-d H:i:s')
                        ]);
                    }
                }
                //</editor-fold>

            }/*foreach end*/

//            pd(,'$insert');
            self::insert(array_values($insert));
            \DB::commit();
        } catch (\PDOException $e) {
            // Woopsy
            \DB::rollback();
            return ['error' => $e->getMessage()];
        }

        return true;
    }

    public function getProducts(){

       $q = \DB::select ('SELECT 
                            pp.id AS primary_id, 	pp.name AS primary_product, 
                            dp.id AS delivery_id, 	dp.name AS delivery_product, 
                            op.id AS addon_id,	op.name AS addon_product
                            
                            FROM  (
                                SELECT pdp.`primary_product_id`,pdp.`delivery_product_id`,dop.`addon_id` 
                                FROM `ev_primary_delivery_product` pdp
                                LEFT JOIN `ev_delivery_addon_product` dop ON dop.`delivery_product_id` = pdp.`delivery_product_id`
                            ) pdo
                            INNER JOIN `ev_product` pp ON pp.id = pdo.`primary_product_id`
                            INNER JOIN `ev_product` dp ON dp.id = pdo.`delivery_product_id`
                            LEFT JOIN `ev_product` op ON op.id = pdo.`addon_id`
                            ');

       return $this->parseToTree((array) $q);
    }

    public function getCompanyProducts_WithSelectedFlag($params){

        $q = \DB::select ("SELECT 
                                pp.id AS primary_id, 	pp.name AS primary_product, 
                                dp.id AS delivery_id, 	dp.name AS delivery_product, 
                                op.id AS addon_id,	op.name AS addon_product,
                                IF(cp.`id`,1,0) AS company_selected
                               
                                FROM  (
                                            SELECT pdp.`primary_product_id`,pdp.`delivery_product_id`,dop.`addon_id` 
                                            FROM `ev_primary_delivery_product` pdp
                                            LEFT JOIN `ev_delivery_addon_product` dop ON dop.`delivery_product_id` = pdp.`delivery_product_id`
                                ) pdo
                                INNER JOIN `ev_product` pp ON pp.id = pdo.`primary_product_id`
                                INNER JOIN `ev_product` dp ON dp.id = pdo.`delivery_product_id`
                                LEFT JOIN `ev_product` op ON op.id = pdo.`addon_id`
                                LEFT JOIN (
                                            SELECT * 
                                            FROM `ev_company_product` WHERE company_id = ".$params['company_id']."
                                ) cp ON cp.`ev_primary_product_id` = pp.id AND cp.`ev_delivery_product_id` = dp.id 
                                order by pp.id,company_selected ASC
                                ");

        return $this->parseToTree((array) $q);
    }

    public function getCompanyAllowedProducts($params){

        $q = \DB::select ("SELECT 
                                pp.id AS primary_id, 	pp.name AS primary_product, 
                                dp.id AS delivery_id, 	dp.name AS delivery_product, 
                                op.id AS addon_id,	op.name AS addon_product,
                                IF(cp.`id`,1,0) AS company_selected
                               
                                FROM  (
                                            SELECT pdp.`primary_product_id`,pdp.`delivery_product_id`,dop.`addon_id` 
                                            FROM `ev_primary_delivery_product` pdp
                                            LEFT JOIN `ev_delivery_addon_product` dop ON dop.`delivery_product_id` = pdp.`delivery_product_id`
                                ) pdo
                                INNER JOIN `ev_product` pp ON pp.id = pdo.`primary_product_id`
                                INNER JOIN `ev_product` dp ON dp.id = pdo.`delivery_product_id`
                                LEFT JOIN `ev_product` op ON op.id = pdo.`addon_id`
                                INNER JOIN (
                                            SELECT * 
                                            FROM `ev_company_product` WHERE company_id = ".$params['company_id']."
                                ) cp ON cp.`ev_primary_product_id` = pp.id AND cp.`ev_delivery_product_id` = dp.id 
                                order by pp.id ASC
                                ");

        return $this->parseToTree((array) $q);
    }

    public function parseToTree($products){

        $parsed = [];

        foreach($products AS $pKey =>  $pItem){

            $pItem = (array) $pItem;

            if(empty($parsed[$pItem['primary_id']])){
                $parsed[$pItem['primary_id']]['id'] = $pItem['primary_id'];
                $parsed[$pItem['primary_id']]['name'] = $pItem['primary_product'];
                $parsed[$pItem['primary_id']]['company_selected'] = $pItem['company_selected'];
            }

            if(!empty($pItem['company_selected'])){
                $parsed[$pItem['primary_id']]['company_selected'] = $pItem['company_selected'];
            }

            $parsed[$pItem['primary_id']]['delivery_products'][$pItem['delivery_id']] = [
                'id' => $pItem['delivery_id'],
                'name' => $pItem['delivery_product'],
                'company_selected' => $pItem['company_selected']
            ];

            if(!empty($pItem['addon_id'])){
                $parsed[$pItem['primary_id']]['delivery_products'][$pItem['delivery_id']]['addon_products'][] = [
                    'id' => $pItem['addon_id'] ,
                    'name' => $pItem['addon_product']
                ];
            }
        }

        /** For using  array_values ONLY*/
        foreach ($parsed AS $prKey => $prItem){
            if(!empty($parsed[$prKey]['delivery_products']))
                $parsed[$prKey]['delivery_products'] = array_values($parsed[$prKey]['delivery_products']);

            if(!empty($parsed[$prKey]['addon_products']))
                $parsed[$prKey]['addon_products'] = array_values($parsed[$prKey]['addon_products']);
        }

//        pd($parsed,'$parsed');
        return $parsed;
    }
}
