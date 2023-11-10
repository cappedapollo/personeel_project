<?php

namespace App\Http\Controllers;

use App;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        checkAuthorization(['admin', 'manager']);
        $page_title = trans_choice('menu.log', 2);
        $role_code = Auth::user()->user_role->role_code;
        if($role_code == 'manager') {
            $user_ids = Auth::user()->employees->pluck('id');
        }elseif($role_code == 'admin') {
            $user_ids = Auth::user()->users->pluck('id');
        }
        
        /* $archive_ids = App\Models\Archive::whereIn('user_id', $user_ids)->pluck('id');
        $ids = $user_ids->concat($archive_ids);
        
        $form_data_ids = App\Models\FormData::whereIn('user_id', $user_ids)->pluck('id');
        $ids = $user_ids->concat($form_data_ids);
        
        $logs = Log::whereIn('module', ['user', 'archive', 'form_data'])->whereIn('module_id', $ids)->orderBy('id', 'desc')->get(); */
        
        $logs = Log::where('module', 'user')->whereIn('module_id', $user_ids)->orderBy('id', 'desc')->get();
        
        $archives = App\Models\Archive::whereIn('user_id', $user_ids)->pluck('id');
        $archive_logs = Log::where('module', 'archive')->whereIn('module_id', $archives)->orderBy('id', 'desc')->get();
        $logs = $logs->merge($archive_logs)->sortDesc();
        
        $form_data_ids = App\Models\FormData::whereIn('user_id', $user_ids)->pluck('id');
        $form_data_logs = Log::where('module', 'form_data')->whereIn('module_id', $form_data_ids)->orderBy('id', 'desc')->get();
        $logs = $logs->merge($form_data_logs)->sortDesc();
        
        return view('logs.index', compact('page_title', 'logs'));
    }
    
    public function view($lang, $module_id, $module)
    {
        checkAuthorization(['admin', 'manager']);
        # create dynamic model
        $model = ucfirst($module);
        $pos = strpos($module, '_');
        $str_to_replace = substr($module, $pos, 2);
        $replace_with = strtoupper(substr($module, $pos+1, 1));
        $model = str_replace($str_to_replace, $replace_with, $model);
        
        $_model = 'App\\Models\\'.$model;
        $data = $_model::find($module_id);
        
        $page_title = trans_choice('menu.log', 2);
        if($module == 'user') {
            $page_title .= ' - '.$data->full_name;
            $page_title .= ($data->function) ? ' - '.$data->function : '';
        }
        
        $logs = Log::where([['module', $module], ['module_id', $module_id]])->orderBy('id', 'desc')->get();
        if($module == 'user') {
            $archives = App\Models\Archive::where('user_id', $module_id)->pluck('id');
            $archive_logs = Log::where('module', 'archive')->whereIn('module_id', $archives)->orderBy('id', 'desc')->get();
            $logs = $logs->merge($archive_logs)->sortDesc();
            
            $form_data_ids = App\Models\FormData::where('user_id', $module_id)->pluck('id');
            $form_data_logs = Log::where('module', 'form_data')->whereIn('module_id', $form_data_ids)->orderBy('id', 'desc')->get();
            $logs = $logs->merge($form_data_logs)->sortDesc();
        }
        
        /* if($module == 'user') {
            $user_ids = collect($module_id);
            $archive_ids = App\Models\Archive::where('user_id', $module_id)->pluck('id');
            $ids = $user_ids->concat($archive_ids);
        
            $form_data_ids = App\Models\FormData::where('user_id', $module_id)->pluck('id');
            $ids = $user_ids->concat($form_data_ids);
        
            $logs = Log::whereIn('module', ['user', 'archive', 'form_data'])->whereIn('module_id', $ids)->orderBy('id', 'desc')->get();
        }else {
            $logs = Log::where([['module', $module], ['module_id', $module_id]])->orderBy('id', 'desc')->get();
        } */
        
        return view('logs.index', compact('page_title', 'logs'));
    }
    
    /* public function store(Request $request)
    {
        $search = $request->search;
        $filter = $search['value'];
        $draw = $request->draw ? $request->draw : 0;
        $start = $request->start ? $request->start : 0;
        $length = $request->length ? $request->length : 50;
        $order = $request->order;
        $sort_column_name = $request->columns[$order[0]['column']]['name'];
        
        $logs = Log::when($filter, function ($query, $filter) {
            $query->where(function($query) use($filter) {
                $query->whereHas('action_by', function ($query) use($filter) {
                    $query->where('first_name', 'like', '%'.$filter.'%')->orWhere('last_name', 'like', '%'.$filter.'%');
                })->orWhereHas('pep', function ($query) use($filter) {
                    $query->where('first_name', 'like', '%'.$filter.'%')->orWhere('last_name', 'like', '%'.$filter.'%');
                })->orWhere('action', 'like', '%'.$filter.'%');
            });
        })->orderBy($sort_column_name, $order[0]['dir']);
        
        $records_total = $records_filtered = $logs->count();
        $logs = $logs->take($length)->skip($start)->get();
        $json = array(
            'draw' => $draw,
            'recordsTotal' => $records_total,
            'recordsFiltered' => $records_filtered,
            'data' => [],
        );
        
        foreach ($logs as $log) {
            $arr = array();
            $action_by = ($log->action_by) ? $log->action_by->full_name : '-';
            $action = $log->action;
            switch($log->module) {
                case 'pep':
                    $pep = $log->pep->full_name;
                    $action = Str::replaceFirst('[pep]', $pep, $action);
                    break;
                default:
            }
            
            if(Str::contains($action, '[user]')) {
                $action = Str::replaceFirst('[user]', $action_by, $action);
            }
            
            array_push($arr, nl2br($action));
            array_push($arr, $log->created_at);
            $json['data'][] = $arr;
        }
        
        return $json;
    } */
}
