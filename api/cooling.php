<?php
$iDataPoints = array(
    array("12:00 AM", "07:00 AM", 500),
    array("08:00 AM", "05:00 PM", 1500),
    array("06:00 PM", "11:00 PM", 500)
);

function hasAnomaly($dataPoint)
{
    global $iDataPoints;
    foreach($iDataPoints as $k => $v){
        $lowerRange = strtotime($v[0]);
        $upperRange = strtotime($v[1]);
        $value = $v[2];
        
        $time = strtotime($dataPoint['Time']);
        if(($time >= $lowerRange && $time <= $upperRange) && (float)$dataPoint['Value'] != (float)$value){
            return true;
        }
    }
    return false;
}

if(!function_exists("getGraphData")){
    function getGraphData()
    {
        if(!isset($_FILES["filename"]['name']))
        {            
            $json['msg'] = "You did not select any file to upload.";
            $json['success'] = false;
            echo json_encode($json);
            die();            
        }
        
        $filedata = ($_FILES['filename']['tmp_name']);
        
        $file = fopen($filedata,"r");
        if(!$file){
            $json = array(
                "msg" => "could not open file",
                "success" => false,
                "file" => $filedata
            );
            echo json_encode($json);
            die();
        }
        
        $first = true;
        $column = array();
        
        $dataPoint = array();
        $hours = array();
        $cdata = array();
        $date = date("Y-m-d H:i:s");
        while(! feof($file))
        {
            if($first){
                $column = fgetcsv($file);
                $first = false;
                
               // var_dump($column);die();
                continue;
            }
            
            $data = fgetcsv($file);
            
            $row = array();
            foreach($column as $k => $cn){
                $row[$cn] = $data[$k];
                
            }
            
            $cdata[strtotime($row['Time'])] = $row;
            $hours[] = $row["Time"];
          
        }
        
        $tempAnomaly = array();
        $consAnomaly = array();
        $anomalyCount = 0;
        $i = 0;
        foreach($cdata as $k => $v):
            $item= array(
                "y" => (float)$v['Value']
            );
            $hasAnomaly = hasAnomaly($v);
            if($hasAnomaly):
                $anomalyCount++;
                $tempAnomaly[$i] = $item;
                $item['marker']["symbol"] = 'url(https://www.highcharts.com/samples/graphics/sun.png)';
            else:
                if(count($tempAnomaly) > 2):
                    //$consAnomaly = array_merge($consAnomaly, $tempAnomaly);
                    foreach($tempAnomaly as $tk => $tv):
                        $consAnomaly[$tk] = $tv;
                    endforeach;
                endif;
                $tempAnomaly = array();
                $anomalyCount = 0;
            endif;
            
            $dataPoint[] = $item;
            if(!isset($consAnomaly[$i])){
                $consAnomaly[$i] = NULL;
            }
            $i++;
        endforeach;

        fclose($file);
        
        gc_collect_cycles();
        
        $json = array(
            "success" => true,
            "hours" => $hours,
            "cdata" => $cdata,
            "data_point" => $dataPoint,
            "consecutive_anomaly" => $consAnomaly
        );
        
        echo json_encode($json);
        die();
    }
}


if(isset($_POST['action']) && $_POST['action'] == "generate"):
    getGraphData();
endif;


