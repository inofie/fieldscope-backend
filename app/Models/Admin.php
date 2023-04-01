<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = "admin";

    public static function create($admin)
    {
        $obj = new static();

        $name = explode(' ', $admin['name']);

        $obj->first_name = $name[0];
        $obj->last_name = isset($name[1]) ? $name[1] : '';
        $obj->email = $admin['email'];
        $obj->password = $admin['password'];
        $obj->forgot_password_hash = '';
        $obj->remember_login_token = '';

        $obj->save();

        return $obj->id;
    }

    public static function getById($id)
    {

        $query = self::select();
        return $query->where('id', $id)
            ->get();
    }

    public static function getByEmail($email)
    {

        $query = self::select();
        return $query->where('email', $email)
            ->get();
    }

    public static function updateByEmail($email, $data)
    {

        $qry_params = [];

        foreach ($data as $column => $row) {
            $qry_params[] = " $column = '$row' ";
        }

        \DB::statement('UPDATE admin SET ' . implode(', ', $qry_params) . " WHERE email = '$email'");
        return true;
    }

    public static function login($email, $password)
    {

        $query = self::select();
        return $query->where('email', $email)
            ->where('password', $password)
            ->get();
    }

    public static function getCountries($params)
    {
        //die('here');
        $query = \DB::table('countries');
        if (!empty($params['id'])) {
            $query->where(['id' => $params['id']]);
        }

        $res = $query->get();
        //print_r($res); die;
        return $res;
    }

    public static function getStates($params)
    {
        //print_r($params); die;
        $query = \DB::table('states');
        if (!empty($params['id'])) {
            $query->where(['id' => $params['id']]);
        } else if (!empty($params['country_id'])) {
            $query->where(['country_id' => $params['country_id']]);
        }

        $res = $query->get();
        //print_r($res); die;
        return $res;
    }

    public static function getCities($params)
    {
        $query = \DB::table('cities');
        if (!empty($params['id'])) {
            $query->where(['id' => $params['id']]);
        } else if (!empty($params['state_id'])) {
            $query->where(['state_id' => $params['state_id']]);
        }

        $query->orderBy('name','ASC');
        $res = $query->get();
        //print_r($res); die;
        return $res;

    }

}
