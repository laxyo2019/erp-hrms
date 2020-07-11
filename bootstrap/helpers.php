<?php 
use App\Models\Employees\Hod;


if (! function_exists('hod_check')) {
    function hod_check($id)
    {
        $hod = Hod::where('user_id', $id)->get();

        return count($hod) !=0 ? true : false;
    }
}






 ?>