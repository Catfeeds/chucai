<?php
post:
http://palcomm-pool.admin.dev/api/auth-api/member-info
{
    'id':1,  //人才信息主键
}
成功返回：

{
    "errcode":0,
    "errmsg":"success",
    "data":
    {
        "id":"1",       //主键
        "name":"nick",      //姓名
        "sex":"1",      //性别 1：男 2：女
        "birthday":"1989-04-20",    //生日
        "na_id":"1",    //国籍主键
        "sh_id":"2",    //学历主键
        "school":"杭州电子科技大学",        //毕业院校
        "job":"项目经理",       //职务
        "job_address":"杭州下沙",       //单位地址
        "tel":"15067124172",    //联系电话
        "wechat":"nickbase",        //微信号
        "email":"palcomm_nick@163.com",     //邮箱
        "telephone":"0571-88888888",    //固定电话
        "resume":"杭州电子科技大学",    //学习简历
        "work_history":"一直创业",  //工作简历
        "fruits":"互联网",     //专业领域
        "service":"杭州掌易网络科技有限公司",   //所属行业
        "status":"1",   //状态
        "create_time":"2017-02-06 10:54:46",    //录入时间
        "update_time":"2017-02-06 04:18:27",    //更新时间
        "dt_id":"1",    //区域主键
        "auth_type":"1",    //授权状态
        "uid":"10000",  //操作主键
        "origin":"1"    //数据来源
        "na":
        {
            "na_id":"1",
            "name":"中国",
            "sort":"1",
            "status":"1"
        },
        "dt":
        {
            "dt_id":"1",
            "name":"平湖市",
            "sort":"1",
            "status":"1"
        },
        "sh":
        {
            "sh_id":"1",
            "name":"本科",
            "sort":"1",
            "status":"1"
        }
    }
}


post:
http://palcomm-pool.admin.dev/api/system-api/area-data
{
    'sh_id':1,  //学历主键
    'sex':1,  //性别 1：男 2：女
    'na_id':1,  //国籍主键
    'start_time':'2015-01-07 10:54:01',     //开始时间
    'end_time':'2017-02-05 15:54:01',       //结束时间
    'name' => 'nick',       //人才名称
    'school' => '杭州电子科技大学',     //毕业院校
    'job' => 'it',      //职业
    'tel' => '15067124172',     //联系电话
    'wechat' => '15067124172',      //微信号
    'email' => '123@163.com',   //邮箱
    'telephone' => '0571-12345678',     //固定电话
    'dt_id' => 1,   //区域主键
}
成功返回：

{
    "errcode":0,
    "errmsg":"success",
    "data":
    [
        {
            "id":"1",       //主键
            "name":"nick",      //姓名
            "sex":"1",      //性别 1：男 2：女
            "birthday":"1989-04-20",    //生日
            "na_id":"1",    //国籍主键
            "sh_id":"2",    //学历主键
            "school":"杭州电子科技大学",        //毕业院校
            "job":"项目经理",       //职务
            "job_address":"杭州下沙",       //单位地址
            "tel":"15067124172",    //联系电话
            "wechat":"nickbase",        //微信号
            "email":"palcomm_nick@163.com",     //邮箱
            "telephone":"0571-88888888",    //固定电话
            "resume":"杭州电子科技大学",    //学习简历
            "work_history":"一直创业",  //工作简历
            "fruits":"互联网",     //专业领域
            "service":"杭州掌易网络科技有限公司",   //所属行业
            "status":"1",   //状态
            "create_time":"2017-02-06 10:54:46",    //录入时间
            "update_time":"2017-02-06 04:18:27",    //更新时间
            "dt_id":"1",    //区域主键
            "auth_type":"1",    //授权状态
            "uid":"10000",  //操作主键
            "origin":"1"    //数据来源
            "na":
            {
                "na_id":"1",
                "name":"中国",
                "sort":"1",
                "status":"1"
            },
            "dt":
            {
                "dt_id":"1",
                "name":"平湖市",
                "sort":"1",
                "status":"1"
            },
            "sh":
            {
                "sh_id":"1",
                "name":"本科",
                "sort":"1",
                "status":"1"
            }
        },
        .......................
    ]
}

post:
http://palcomm-pool.admin.dev/api/system-api/area-data
{
    'sh_id':1,  //学历主键
    'sex':1,  //性别 1：男 2：女
    'na_id':1,  //国籍主键
    'start_time':'2015-01-07 10:54:01',     //开始时间
    'end_time':'2017-02-05 15:54:01',       //结束时间
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    [
    {
        "sum_num":"2",      //统计人数
        "dt_id":"1",    //区域主键
        "name":"本科",    //区域名称
        "member":   //人才详细信息
        {

        }
    },
    ................
    ]
}

post:
http://palcomm-pool.admin.dev/api/system-api/sex-data
{
    'dt_id':1,  //区域主键
    'sex':1,  //性别 1：男 2：女
    'na_id':1,  //国籍主键
    'start_time':'2015-01-07 10:54:01',     //开始时间
    'end_time':'2017-02-05 15:54:01',       //结束时间
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    [
    {
        "sum_num":"2",      //统计人数
        "sh_id":"1",    //学历主键
        "name":"本科",    //学历名称
        "sh":   //学历详细信息
        {
            "sh_id":"1",
            "name":"本科",
            "sort":"1",
            "status":"1"
        }
    },
    ................
    ]
}


post:
http://palcomm-pool.admin.dev/api/system-api/sex-data
{
    'dt_id':1,  //区域主键
    'sex':1,  //性别 1：男 2：女
    'na_id':1,  //国籍主键
    'start_time':'2015-01-07 10:54:01',     //开始时间
    'end_time':'2017-02-05 15:54:01',       //结束时间
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    [
        {
            "sum_num":"2",      //统计人数
            "sh_id":"1",    //学历主键
            "name":"本科",    //学历名称
            "sh":   //学历详细信息
            {
                "sh_id":"1",
                "name":"本科",
                "sort":"1",
                "status":"1"
            }
        },
        ................
    ]
}

post:
http://palcomm-pool.admin.dev/api/system-api/sex-data
{
    'dt_id':1,  //区域主键
    'sh_id':1,  //学历主键
    'na_id':1,  //国籍主键
    'start_time':'2015-01-07 10:54:01',     //开始时间
    'end_time':'2017-02-05 15:54:01',       //结束时间
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    {
        "boy_num":4,        //男性数量
        "girl_num":0,       //女性数量
    }
}

post:
http://palcomm-pool.admin.dev/api/auth-api/apply
{
    "openid":"123456",      //用户openid
    "name":"\u59d3\u540d",      //姓名
    "sex":1,    //性别 1：男 2：女
    "birthday":"2017-01-12",    //生日
    "na_id":1,  //国籍主键
    "sh_id":1,  //学历主键
    "school":"\u6bd5\u4e1a\u5b66\u6821",    //毕业学校
    "job":"\u73b0\u5de5\u4f5c\u53ca\u804c\u52a1",   //现工作及职务
    "job_address":"\u73b0\u5de5\u4f5c(\u5b66\u4e60)\u5355\u4f4d\u5730\u5740",  //现工作(学习)单位地址
    "tel":"15067124172",   //手机号码
    "wechat":"\u5fae\u4fe1\u53f7",  //微信号
    "email":"\u90ae\u7bb1", //邮箱
    "telephone":"0571-123456", //固定电话
    "resume":"\u4e2a\u4eba\u5b66\u4e60\u7b80\u5386",    //个人学习简历
    "work_history":"\u5de5\u4f5c\u7ecf\u5386",      //工作经历
    "fruits":"\u4e2a\u4eba\u4e13\u4e1a\u9886\u57df\u3001\u4e3b\u8981\u6210\u679c\u7b49",    //个人专业领域、主要成果等
    "service":"\u521b\u529e\u516c\u53f8\u6240\u5c5e\u884c\u4e1a\u3001\u4e3b\u8425\u4e1a\u52a1\u53ca\u89c4\u6a21\u7b49",     //创办公司所属行业、主营业务及规模等
    "dt_id":1   //所属区域主键
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    { 
        
    }
}

post:
http://palcomm-pool.admin.dev/api/base-api/lables
{
    
}
成功返回：
{
    "errcode":0,
    "errmsg":"success",
    "data":
    {
        "dtList":       //区域列表
        [
            {
                "dt_id":"1",    //主键
                "name":"平湖市",   //名称
                "sort":"1",     //排序
                "status":"1"    //状态
            },
            ................
        ],
        "naList":   //国籍列表
        [
            {
                "na_id":"1",    //主键
                "name":"中国",    //名称
                "sort":"1",     //排序
                "status":"1"    //状态
            },
            .................
        ],
        "sgList":       //学历列表
            [
                {
                    "sh_id":"1",    //主键
                    "name":"本科",    //名称
                    "sort":"1",     //排序
                    "status":"1"    //状态
                },
                ..............
            ]
    }
}

                
                
                