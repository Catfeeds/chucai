<?php


function getVerifyCode($length=6)
{
    $chars = [
        'A','B','F','W','X','Z','M','N','T','H','K','0','1','2','3','4','5','6','7','8','9'
    ];

    // 在 $chars 中随机取 $length 个数组元素键名
    $keys = array_rand($chars, $length);

    $verify_code = '';
    for($i = 0; $i < $length; $i++)
    {
        // 将 $length 个数组元素连接成字符串
        $verify_code .= $chars[$keys[$i]];
    }
    return $verify_code;
}

/**
 * excel字母排序
 */
function getExcelNum($num=26)
{
    $chararr = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    $lie = 0;
    $info = array();
    for ($i=0;$i<=$num;$i++)
    {
        foreach ($chararr as $v)
        {
            if ($lie >=1 )
            {
                $info[] = $v.$chararr[$lie-1];
            }
            else 
            {
                $info[] = $v;
            }
            
            $i++;
        }
        $lie += 1;
    }
    return $info;
}

//生成唯一标识符
//sha1()函数， "安全散列算法（SHA1）"
function create_unique($uid=NULL) {
    $agent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT']:'undefine1';
    $addr = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:'undefine2';
    $data = $uid == NULL ? $agent . $addr
        .time() . rand() : $agent . $addr
        . $uid .time() . rand();

    return sha1($data);
}
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

function auto_increasing(){
    return time();
}

//标准返回函数
function response($errcode=0,$errmsg="success.",$data=null){
    return !is_array($data)?['errcode'=>$errcode,'errmsg'=>$errmsg]:['errcode'=>$errcode,'errmsg'=>$errmsg,'data'=>$data];
}

//标准模型错误函数
function modelError($model){
    if (!$model) {
        return "未定义错误类型:空模型";
    }

    if (isset($model->errors) && isset($model->errors['errmsg']) && isset($model->errors['errmsg'][0])) {
        return $model->errors['errmsg'][0];
    }
    return "未定义错误类型:找不到错误信息";
}

function request($url,$params){
    if($url == NULL) {
        return NULL;
    }
    $paramstring = http_build_query($params);

    $ch = curl_init();
    $timeout = 5;
    curl_setopt ($ch, CURLOPT_URL, $url."?".$paramstring);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    return $file_contents;
}