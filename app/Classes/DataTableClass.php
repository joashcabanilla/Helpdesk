<?php

namespace App\Classes;


class DataTableClass
{
    public function processTable($param){
     $final_query = $param['sql'];
     $columns = $param['columns'];
     $result['iTotalRecords'] = 0;
     $param['union'] = !empty($param['union']) ? $param['union'] : array() ;
     $counter = 0;

     if(isset($param['group'])&&$param['group']):
         $result["iTotalRecords"] = count($param['sql']->groupBy($param['group'])->distinct($param['group'])->get());
     elseif(isset($param['having'])&&$param['having']):
         $result["iTotalRecords"] = count($param['sql']->having($param['having'][0][0],$param['having'][0][1],$param['having'][0][2])->get());
     elseif(isset($param['distinct'])&&$param['distinct']):
         if(isset($param['union']) && $param['union']):
             if(count($param['union'])>0):
                 foreach($param['union'] as $unions):
                     $counter++;

                     $result["iTotalRecords"] += $unions->distinct($param['distinct'])->count();
                     if($counter!=1):
                         $final_query = $final_query->unionAll($unions);
                     endif;
                 endforeach;
             endif;
         else:
             $result["iTotalRecords"] = $param['sql']->distinct($param['distinct'])->count();
         endif;

     else:
         $result["iTotalRecords"] = $param['sql']->count();
     endif;
     if( $param['var']->length > 0 ){
         $final_query = $final_query->skip(intval($param['var']->start))->take(intval($param['var']->length));
     }

     $result["iTotalDisplayRecords"] = $result["iTotalRecords"];

     if(isset($param['group'])&&$param['group']):
         $tmpgroup = is_array($param['group'])?$param['group']:[$param['group']];
         $final_query = call_user_func_array([$final_query,'groupBy'],$tmpgroup);
     endif; 
     if(isset($param['having'])&&$param['having']):
         foreach ($param['having'] as $con):
             $final_query = call_user_func_array([$final_query,'having'],$con);
         endforeach;
     endif;
     if(isset($param['distinct'])&&$param['distinct']) $final_query->distinct();


     $result["aaData"] = array();
     $count = intval($param['var']->start?$param['var']->start:0);
     
     foreach ($final_query->get() as $finres){
         $count ++;
         $isAModel = is_a($finres,'Illuminate\Database\Eloquent\Model');
         $mrow = $isAModel ? $finres : (array) $finres;

         $tmpr = array();
         foreach ($columns as $cc=>$cval) {
             $val = $mrow[ $cval['db'] ];

             if(isset($cval['sortnum'])&&$cval['sortnum']){
                 $tmpr[] = $count;
             }else if ( isset( $cval['formatter'] ) ) {
                 $tmpr[] = $cval['formatter']( $val, $mrow);
             }else {
                 $tmpr[] = $val;
             }
         }
         $result["aaData"][] = $tmpr;
     }

     echo json_encode($result);
 }
}
