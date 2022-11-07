<?php

    function get_client_ip(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        $json     = file_get_contents("http://ipinfo.io/$ipaddress?token=e6071e0f7d2767");   
        $json     = json_decode($json, true);
        return $json;
    }

    function validate_if_mcc_ip() {
        $valid = false;        
        $client_ip = get_client_ip()['ip'];        
        if($client_ip == "127.0.0.1" || $client_ip == "58.69.75.55" || $client_ip == "58.69.75.56" || $client_ip == "58.69.75.57" || $client_ip == "58.69.75.58" || $client_ip == "58.69.75.159" || $client_ip == "122.3.205.193")
            $valid = true;
        return $valid;
    }

    function db_json_array_to_string($str) {
        return str_replace(array("[", "]", '"'), "", $str);
    }

    function custom_date_format($date, $format) {
        return date_format(date_create($date), $format);
    }

    function get_month_last_date($strDate) {
        return date("t", strtotime($strDate));
    }

    function remove_time_am_pm_indicator($strDate) {
        return str_replace(array(" AM", " PM"), "", $strDate);
    }

    function process_employee_dtr($attendanceLogs) {        
        $data['time']['AM']['IN'] = '';
        $data['time']['AM']['OUT'] = '';
        $data['time']['PM']['IN'] = '';
        $data['time']['PM']['OUT'] = '';

        $data['id']['AM']['IN'] = 0;
        $data['id']['AM']['OUT'] = 0;
        $data['id']['PM']['IN'] = 0;
        $data['id']['PM']['OUT'] = 0;
        
        if($attendanceLogs) {
            foreach ($attendanceLogs as $key => $attendanceLog) {
                if($key == 0){
                    $data['id'][custom_date_format($attendanceLog->time, "A")][$attendanceLog->type] = $attendanceLog->id;
                    $data['time'][custom_date_format($attendanceLog->time, "A")][$attendanceLog->type] = custom_date_format($attendanceLog->time, "h:i:s A");                    
                }
                elseif ($key < $attendanceLogs->count()) {
                    if($attendanceLog->type == 'OUT' && (Carbon::create($attendanceLog->time)->lessThan(Carbon::create("12:31:00")))) {                                            
                        $data['id']['AM'][$attendanceLog->type] = $attendanceLog->id;
                        $data['time']['AM'][$attendanceLog->type] = custom_date_format($attendanceLog->time, "h:i:s A");
                    }
                    else{                        
                        $data['id'][custom_date_format($attendanceLog->time, "A")][$attendanceLog->type] = $attendanceLog->id;
                        $data['time'][custom_date_format($attendanceLog->time, "A")][$attendanceLog->type] = custom_date_format($attendanceLog->time, "h:i:s A");
                    }
                }
            }
        }
        return $data;        
    }

    function compute_total_work_minutes($time_am_in, $time_am_out, $time_pm_in, $time_pm_out) {                
        $total_man_minutes = 0;
        // echo $time_am_in . ' ' . $time_am_out . ' ' . $time_pm_in . ' ' . $time_pm_out . '<br>';

        if($time_pm_out != '' && $time_pm_in != '' && $time_am_out != '' && $time_am_in != '') {
            $time_out = new Carbon($time_pm_out);
            $time_in = new Carbon($time_pm_in);            
            $total_man_minutes += $time_out->diffInMinutes($time_in);

            $time_out = new Carbon($time_am_out);
            $time_in = new Carbon($time_am_in);            
            $total_man_minutes += $time_out->diffInMinutes($time_in);

        }
        else {
            if($time_pm_out != '' && $time_pm_in != '') {            
                $time_out = new Carbon($time_pm_out);
                $time_in = new Carbon($time_pm_in);            
                $total_man_minutes += $time_out->diffInMinutes($time_in);
            }
    
            if($time_am_out != '' && $time_am_in != '') {            
                $time_out = new Carbon($time_am_out);
                $time_in = new Carbon($time_am_in);            
                $total_man_minutes += $time_out->diffInMinutes($time_in);
            }
    
            if($time_pm_out != '' && $time_am_in != '') {
                $time_out = new Carbon($time_pm_out);
                $time_in = new Carbon($time_am_in);            
                                
                if($time_out->greaterThan(Carbon::create("12:59:59")))
                    $total_man_minutes += $time_out->diffInMinutes($time_in) - 60;
                elseif($time_out->greaterThan(Carbon::create("11:59:59")))
                    $total_man_minutes += $time_out->diffInMinutes($time_in) - Carbon::create("12:00:00")->diffInMinutes($time_out);
                else
                    $total_man_minutes += $time_out->diffInMinutes($time_in);
            }
        }        

        return $total_man_minutes;
    }

    function process_employee_dtr_detailed($attendanceLogs) {        
        $data = [];
        
        if($attendanceLogs) {
            foreach ($attendanceLogs as $key => $attendanceLog) {
                $data[$attendanceLog->type][] = custom_date_format($attendanceLog->time, "h:i:s A");                
            }
        }
        return $data;        
    }

    function compute_total_work_minutes_detailed($time_in, $time_out) {                
        $total_man_minutes = 0;

        if($time_out != '' && $time_in != '') {
            $time_out = new Carbon($time_out);
            $time_in = new Carbon($time_in);            
                            
            if($time_out->greaterThan(Carbon::create("12:59:59")))
                $total_man_minutes += $time_out->diffInMinutes($time_in) - 60;
            elseif($time_out->greaterThan(Carbon::create("11:59:59")))
                $total_man_minutes += $time_out->diffInMinutes($time_in) - Carbon::create("12:00:00")->diffInMinutes($time_out);
            else
                $total_man_minutes += $time_out->diffInMinutes($time_in);
        }               

        return $total_man_minutes;
    }

    function get_payroll_period($date_from, $date_to) {
        return custom_date_format($date_from, "F d") . ' - ' . custom_date_format($date_to, "d, Y");        
    }

    function get_dtr_tardiness($date, $type, $time, $schedule) {
        $day = Carbon::parse($date)->format('l');
        $attendance_time = Carbon::parse($time);
        $scheduled_time = Carbon::parse($schedule[$type][$day]);
        
        if($type == 'IN' && ($attendance_time->greaterThan($scheduled_time)))
            return $attendance_time->diffInMinutes($scheduled_time);    
        elseif($type == 'OUT' && ($attendance_time->lessThan($scheduled_time->addSeconds(59))))
            return $attendance_time->diffInMinutes($scheduled_time);
        else
            return 0;
    }

    function check_dtr_tardiness($date, $type, $time, $schedule) {
        $day = Carbon::parse($date)->format('l');
        $attendance_time = Carbon::parse($time);
        $scheduled_time = Carbon::parse($schedule[$type][$day]);
        
        if($type == 'IN' && ($attendance_time->greaterThan($scheduled_time->addSeconds(59))))
            return '<span class="text-danger">' . $time . '</span>';        
        elseif($type == 'OUT' && ($attendance_time->lessThan($scheduled_time)))
            return '<span class="text-danger">' . $time . '</span>';
        else
            return '<span>' . $time . '</span>';
    }

    function check_user_access($user_level){        
        if(in_array(Auth::user()->user_role, $user_level))
            return true;
        else
            return false;
    }