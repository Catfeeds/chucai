'use strict';
//自定义指令
//repeatFinish指令
app.directive('repeatFinish',function(){
    return {
        restrict: 'A',
        link: function(scope,element,attr){
            if(scope.$last == true){
                scope.$eval(attr.repeatFinish)
            }
        }
    }
});
//单选
app.directive('pieRadio', function() {
    var option = {
        restrict: 'AECM',
        scope : {
            myId : '@',        //解析普通字符串
            myData : '=',    //解析数据
            myFn : '&'        //函数
        },
        transclude : true,
        templateUrl: 'tpl/template/radio.html',
        link:function(scope,elements,attributes){
            //初始化值
            var keep=true;
            angular.forEach(scope.myData.list,function (item,index){
                if(keep){
                    if(item==scope.myData.result){
                        scope.active=index;
                        keep=false;
                    }
                }
            });
            if(keep){
                scope.active=null;
            }
            //选择
            scope.setData=function (index,name) {
                scope.data=name;
                scope.active=index;
            };
            //确认
            scope.confirm=function(){
                scope.myData.result=scope.data;
                scope.oData=scope.data.toString();
                scope.oActive=scope.active.toString();
                scope.myData.show=false;
            };
            //取消
            scope.cancel=function () {
                !scope.oData?scope.oData=scope.myData.result:'';
                scope.myData.result=scope.oData;
                scope.active= scope.oActive;
                scope.myData.show=false;
            }
        }
    };
    return option;
});
//纯多选
app.directive('pieCheckbox1', function() {
    var option = {
        restrict: 'AECM',
        scope : {
            myId : '@',        //解析普通字符串
            myData : '=',    //解析数据
            myFn : '&'        //函数
        },
        transclude : true,
        templateUrl: 'tpl/template/checkbox.html',
        controller:function($scope,$element,$attrs,$transclude) {
            //初始化值
            $scope.ready=function () {
                if($scope.myData.result.indexOf('选择')<0){
                    $scope.data=$scope.myData.result.split(',');
                    //已选择添加class
                    var oSpan=$element.find('ul').find('span');
                    angular.forEach($scope.myData.iList,function (oI) {
                        oSpan.eq(oI).addClass('active');
                    });
                }else{
                    $scope.data=[];
                }
            }
        },
        link:function(scope,elements,attributes){
            scope.data=[];
            scope.oData=scope.myData.result;
            //设置值
            scope.setData=function (i,name) {
                var item=elements.find('span').eq(i);
                if(item.hasClass('active')){
                    scope.removeData(name);
                    item.removeClass('active');
                }else{
                    item.addClass('active');
                    scope.data.push(name);
                    scope.myData.iList.push(i);
                }
            };
            //去除已选择
            scope.removeData=function (name) {
                var keep2=true;
                angular.forEach(scope.data,function (item,index) {
                    if(keep2){
                        if(item==name){
                            scope.data.splice(index,1);
                            scope.myData.iList.splice(index,1);
                            keep2=false;
                        }
                    }
                })
            };
            //确认
            scope.confirm=function(){
                scope.myData.result=scope.data.toString();
                scope.oData=scope.data.toString();//备份数据
                scope.oIList=scope.myData.iList.concat([]);//备份数据
                scope.myData.show=false;
            };
            //取消
            scope.cancel=function () {
                scope.cancelData=scope.oData.split(',');//还原数据
                scope.myData.iList=scope.oIList;//还原数据
                elements.find('span').removeClass('active');
                var oSpan=elements.find('ul').find('span');
                angular.forEach(scope.myData.iList,function (oI) {
                    oSpan.eq(oI).addClass('active');
                });
                scope.myData.show=false;
            }
        }
    };
    return option;
});
//含有其他和以上均没有
app.directive('pieCheckbox2', function() {
    var option = {
        restrict : 'AECM',
        scope : {
            myId : '@',        //解析普通字符串
            myData : '=',    //解析数据
            myFn : '&'        //函数
        },
        transclude : true,
        templateUrl: 'tpl/template/checkbox.html',
        controller:function($scope,$element,$attrs,$transclude) {
            //初始化值
            $scope.ready=function () {
                if($scope.myData.result.indexOf('选择')<0){
                    $scope.data=$scope.myData.result.split(',');
                    //已选择添加class
                    var oSpan=$element.find('ul').find('span');
                    angular.forEach($scope.myData.iList,function (oI) {
                        oSpan.eq(oI).addClass('active');
                    });
                }else{
                    $scope.data=[];
                }
            }
        },
        link:function(scope,elements,attributes){
            scope.oData=scope.myData.result;
            //设置值
            scope.setData=function (i,name) {
                var item=elements.find('span').eq(i);
                var length=scope.myData.list.length;
                if(i == length-2 || i == length-1){
                    scope.data=[];
                    scope.myData.iList=[];
                    elements.find('span').removeClass('active');
                    if(!item.hasClass('active')){
                        item.addClass('active');
                        scope.data.push(name);
                        scope.myData.iList.push(i);
                    }
                }else{
                    scope.removeData(elements.find('span').eq(length-1).text());
                    scope.removeData(elements.find('span').eq(length-2).text());
                    if(item.hasClass('active')){
                        scope.removeData(name);
                        item.removeClass('active');
                    }else{
                        item.addClass('active');
                        elements.find('span').eq(length-1).removeClass('active');
                        elements.find('span').eq(length-2).removeClass('active');
                        scope.data.push(name);
                        scope.myData.iList.push(i)
                    }
                }
            };
            //去除已选择
            scope.removeData=function (name) {
                var keep2=true;
                angular.forEach(scope.data,function (item,index) {
                    if(keep2){
                        if(item==name){
                            scope.data.splice(index,1);
                            scope.myData.iList.splice(index,1);
                            keep2=false;
                        }
                    }
                })
            };
            //确认
            scope.confirm=function(){
                scope.myData.result=scope.data.toString();
                scope.oData=scope.data.toString();//备份数据
                scope.oIList=scope.myData.iList.concat([]);//备份数据
                scope.myData.show=false;
            };
            //取消
            scope.cancel=function () {
                scope.cancelData=scope.oData.split(',');//还原数据
                scope.myData.iList=scope.oIList;//还原数据
                elements.find('span').removeClass('active');
                var oSpan=elements.find('ul').find('span');
                angular.forEach(scope.myData.iList,function (oI) {
                    oSpan.eq(oI).addClass('active');
                });
                scope.myData.show=false;
            }
        }
    };
    return option;
});
//只有以上均没有
app.directive('pieCheckbox3', function() {
    var option = {
        restrict: 'AECM',
        scope : {
            myId : '@',        //解析普通字符串
            myData : '=',    //解析数据
            myFn : '&'        //函数
        },
        transclude : true,
        templateUrl: 'tpl/template/checkbox.html',
        controller:function($scope,$element,$attrs,$transclude) {
            //初始化值
            $scope.ready=function () {
                if($scope.myData.result.indexOf('选择')<0){
                    $scope.data=$scope.myData.result.split(',');
                    console.log($scope.data);
                    //已选择添加class
                    var oSpan=$element.find('ul').find('span');
                    angular.forEach($scope.myData.iList,function (oI) {
                        oSpan.eq(oI).addClass('active');
                    });
                }else{
                    $scope.data=[];
                }
            }
        },
        link:function(scope,elements,attributes){
            scope.data=[];
            scope.oData=scope.myData.result;
            //设置值
            scope.setData=function (i,name) {
                var item=elements.find('span').eq(i);
                var length=scope.myData.list.length;
                if(i == length-1){
                    scope.data=[];
                    scope.myData.iList=[];
                    elements.find('span').removeClass('active');
                    if(!item.hasClass('active')){
                        item.addClass('active');
                        scope.data.push(name);
                        scope.myData.iList.push(i);
                    }
                }else{
                    scope.removeData(elements.find('span').eq(length-1).text());
                    if(item.hasClass('active')){
                        scope.removeData(name);
                        item.removeClass('active');
                    }else{
                        item.addClass('active');
                        elements.find('span').eq(length-1).removeClass('active');
                        scope.data.push(name);
                        scope.myData.iList.push(i)
                    }
                }
            };
            //去除已选择
            scope.removeData=function (name) {
                var keep2=true;
                angular.forEach(scope.data,function (item,index) {
                    if(keep2){
                        if(item==name){
                            scope.data.splice(index,1);
                            scope.myData.iList.splice(index,1);
                            keep2=false;
                        }
                    }
                })
            };
            //确认
            scope.confirm=function(){
                scope.myData.result=scope.data.toString();
                scope.oData=scope.data.toString();//备份数据
                scope.oIList=scope.myData.iList.concat([]);//备份数据
                scope.myData.show=false;
            };
            //取消
            scope.cancel=function () {
                scope.cancelData=scope.oData.split(',');//还原数据
                scope.myData.iList=scope.oIList;//还原数据
                elements.find('span').removeClass('active');
                var oSpan=elements.find('ul').find('span');
                angular.forEach(scope.myData.iList,function (oI) {
                    oSpan.eq(oI).addClass('active');
                });
                scope.myData.show=false;
            }
        }
    };
    return option;
});
app.controller('homeTcdzCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
    //弹窗
    $scope.mPop={
        content:{
            type: 'success',
            title: '通知',
            text: 'Message',
            dataout:2000
        },
        launch:function () {
            toaster.pop($scope.mPop.content.type, $scope.mPop.content.title, $scope.mPop.content.text,$scope.mPop.content.dataout);
        },
        info:function (text) {
            $scope.mPop.content.type='success';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        },
        err:function (text) {
            $scope.mPop.content.type='error';
            $scope.mPop.content.text=text;
            $scope.mPop.launch();
        }

    };
    //默认数据
    if(!$sessionStorage.quesOption){
        $sessionStorage.quesOption={
            token:$sessionStorage.token,
            age:'选择年龄',//年龄
            sex:'是',//性别
            is_sexual:'是',//性生活
            height:null,//身高
            weight:null,//体重
            waist:null,//腰围
            family_history:'选择家族史',//家族史
            past_history:'选择既往病史',//既往病史
            allerg_history:'选择过敏史',//过敏史
            sit:'是',//静坐为主
            sleep:'是',//睡眠充足
            sleep_quality:'选择',//睡眠质量
            habit:'选择',//习惯
            smoke:'是',//超过20支烟
            smoke_year:'选择',//烟龄
            passive_smoke:'选择',//被动吸烟
            exercise:'选择',//锻炼
            diet:'选择',//膳食搭配
            drink:'选择',//每日饮水量
            anorectal:'选择',//便秘腹泻等
            urinary:'选择',//尿不畅等
            blue:'选择',//精神压抑
            vertebral:'选择',//颈椎
            examination:'选择',//血脂异常等
            burn:'是',//生育意愿
            breast:'选择',//乳腺疾病
            menstruation:'选择',//月经
            menopause:'选择',//绝经
            TCT:'是',//TCT
            pregnant:'是',//怀孕
            physical:'选择',//身体状况
            doctor_number:'选择',//看过医生次数
            exam:'是',//体检
            symptom:'选择',//症状
            activity:'选择'//活动困难
        };
        $sessionStorage.iList={
            list2:[],
            list3:[],
            list4:[],
            list6:[],
            list12:[],
            list13:[],
            list15:[],
            list16:[],
            list17:[],
            list22:[],
            list23:[]
        }
    }
    //问卷数据
    $scope.quesData={
        ques1:{//年龄
            list:['18岁以下','18-20岁','21-35岁','36-40岁','41-44岁','45-50岁','51-55岁','56-80岁','80岁以上'],
            result:$sessionStorage.quesOption.age,
            show:false
        },
        ques2:{//家族史
            list:['高血压','糖尿病','脑血管病','肝病','肾病','心血管病','肿瘤','呼吸系统疾病','血脂异常','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.family_history,
            show:false,
            iList:$sessionStorage.iList.list2
        },
        ques3:{//既往病史
            list:['高血压','糖尿病','脑血管病','肝病','肾病','心血管病','肿瘤','呼吸系统疾病','血脂异常','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.past_history,
            show:false,
            iList:$sessionStorage.iList.list3
        },
        ques4:{//3.过敏史
            list:['药物','食物','气味','花粉','季节交替','气候变化','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.allerg_history,
            show:false,
            iList:$sessionStorage.iList.list4
        },
        ques5:{//睡眠质量
            list:['好','一般','较差 ','差'],
            result:$sessionStorage.quesOption.sleep_quality,
            show:false
        },
        ques6:{//习惯
            list:['吸烟','酗酒','节食','熬夜','暴饮暴食','以上均没有'],
            result:$sessionStorage.quesOption.habit,
            show:false,
            iList:$sessionStorage.iList.list6
        },
        ques7:{//吸烟年限
            list:['1年内','1-5年','6-10年','11年以上','以上均没有'],
            result:$sessionStorage.quesOption.smoke_year,
            show:false
        },
        ques8:{//被动吸烟
            list:['经常','偶尔','没有'],
            result:$sessionStorage.quesOption.passive_smoke,
            show:false
        },
        ques9:{//体育锻炼
            list:['经常','偶尔','不参加'],
            result:$sessionStorage.quesOption.exercise,
            show:false
        },
        ques10:{//膳食搭配
            list:['以荤为主','以素为主','荤素各半','全素食'],
            result:$sessionStorage.quesOption.diet,
            show:false
        },
        ques11:{//每日饮水量
            list:['500ML以下','500-1000ML','1000M-1500ML','1500-2000ML','2000ML以上'],
            result:$sessionStorage.quesOption.drink,
            show:false
        },
        ques12:{//以下情况
            list:['便秘','腹泻','便血','以上均没有'],
            result:$sessionStorage.quesOption.anorectal,
            show:false,
            iList:$sessionStorage.iList.list12
        },
        ques13:{//以下情况
            list:['尿不畅','尿频尿急尿痛','血尿','其它','以上均没有'],
            result:$sessionStorage.quesOption.urinary,
            show:false,
            iList:$sessionStorage.iList.list13
        },
        ques14:{//精神压抑
            list:['经常','偶尔','没有'],
            result:$sessionStorage.quesOption.blue,
            show:false
        },
        ques15:{//颈椎/腰椎疾病
            list:['有颈椎病','有腰椎病','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.vertebral,
            show:false,
            iList:$sessionStorage.iList.list15
        },
        ques16:{//体检是情况
            list:['血脂异常','心电图异常','红细胞异常','血糖增高','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.examination,
            show:false,
            iList:$sessionStorage.iList.list16
        },
        ques17:{//乳腺疾病史
            list:['乳腺炎','乳腺增生','乳腺纤维瘤','乳癌','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.breast,
            show:false,
            iList:$sessionStorage.iList.list17
        },
        ques18:{//初潮
            list:['尚未初潮','13岁以下','13-16岁','17岁以上'],
            result:$sessionStorage.quesOption.menstruation,
            show:false
        },
        ques19:{//绝经
            list:['尚未绝经','45岁以下','45-49岁','50岁以上'],
            result:$sessionStorage.quesOption.menopause,
            show:false
        },
        ques20:{//身体状况
            list:['好','一般','较差','很差'],
            result:$sessionStorage.quesOption.physical,
            show:false
        },
        ques21:{//几次医生
            list:['没去过','5次以下','5次以上'],
            result:$sessionStorage.quesOption.doctor_number,
            show:false
        },
        ques22:{//症状
            list:['记忆力减退','头脑不清晰','视力障碍','听力障碍','嗅觉障碍','行走不方便','吃饭困难','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.symptom,
            show:false,
            iList:$sessionStorage.iList.list22
        },
        ques23:{//困难活动
            list:['吃饭','洗澡','上下床','穿衣','打扫卫生','室内行走','上厕所','其它','以上均没有/不清楚'],
            result:$sessionStorage.quesOption.activity,
            show:false,
            iList:$sessionStorage.iList.list23
        }
    };
    $scope.option=$sessionStorage.quesOption;
    //监听(缓存数据)
    $scope.$watchGroup(
        [
            'quesData.ques1.result',
            'quesData.ques2.result',
            'quesData.ques3.result',
            'quesData.ques4.result',
            'quesData.ques5.result',
            'quesData.ques6.result',
            'quesData.ques7.result',
            'quesData.ques8.result',
            'quesData.ques9.result',
            'quesData.ques10.result',
            'quesData.ques11.result',
            'quesData.ques12.result',
            'quesData.ques13.result',
            'quesData.ques14.result',
            'quesData.ques15.result',
            'quesData.ques16.result',
            'quesData.ques17.result',
            'quesData.ques18.result',
            'quesData.ques19.result',
            'quesData.ques20.result',
            'quesData.ques21.result',
            'quesData.ques22.result',
            'quesData.ques23.result',
            'option.sex',
            'option.is_sexual',
            'option.height',
            'option.weight',
            'option.waist',
            'option.sit',
            'option.sleep',
            'option.smoke',
            'option.burn',
            'option.TCT',
            'option.pregnant',
            'option.exam',
            'quesData.ques2.iList',
            'quesData.ques3.iList',
            'quesData.ques4.iList',
            'quesData.ques6.iList',
            'quesData.ques12.iList',
            'quesData.ques13.iList',
            'quesData.ques15.iList',
            'quesData.ques16.iList',
            'quesData.ques17.iList',
            'quesData.ques22.iList',
            'quesData.ques23.iList'
        ],function (newValue)
        {
            $sessionStorage.quesOption.age=$scope.option.age=newValue[0];
            $sessionStorage.quesOption.family_history=$scope.option.family_history=newValue[1];
            $sessionStorage.quesOption.past_history=$scope.option.past_history=newValue[2];
            $sessionStorage.quesOption.allerg_history=$scope.option.allerg_history=newValue[3];
            $sessionStorage.quesOption.sleep_quality=$scope.option.sleep_quality=newValue[4];
            $sessionStorage.quesOption.habit=$scope.option.habit=newValue[5];
            $sessionStorage.quesOption.smoke_year=$scope.option.smoke_year=newValue[6];
            $sessionStorage.quesOption.passive_smoke=$scope.option.passive_smoke=newValue[7];
            $sessionStorage.quesOption.exercise=$scope.option.exercise=newValue[8];
            $sessionStorage.quesOption.diet=$scope.option.diet=newValue[9];
            $sessionStorage.quesOption.drink=$scope.option.drink=newValue[10];
            $sessionStorage.quesOption.anorectal=$scope.option.anorectal=newValue[11];
            $sessionStorage.quesOption.urinary=$scope.option.urinary=newValue[12];
            $sessionStorage.quesOption.blue=$scope.option.blue=newValue[13];
            $sessionStorage.quesOption.vertebral=$scope.option.vertebral=newValue[14];
            $sessionStorage.quesOption.examination=$scope.option.examination=newValue[15];
            $sessionStorage.quesOption.breast=$scope.option.breast=newValue[16];
            $sessionStorage.quesOption.menstruation=$scope.option.menstruation=newValue[17];
            $sessionStorage.quesOption.menopause=$scope.option.menopause=newValue[18];
            $sessionStorage.quesOption.physical=$scope.option.physical=newValue[19];
            $sessionStorage.quesOption.doctor_number=$scope.option.doctor_number=newValue[20];
            $sessionStorage.quesOption.symptom=$scope.option.symptom=newValue[21];
            $sessionStorage.quesOption.activity=$scope.option.activity=newValue[22];
            $sessionStorage.quesOption.sex=newValue[23];
            $sessionStorage.quesOption.is_sexual=newValue[24];
            $sessionStorage.quesOption.height=newValue[25];
            $sessionStorage.quesOption.weight=newValue[26];
            $sessionStorage.quesOption.waist=newValue[27];
            $sessionStorage.quesOption.sit=newValue[28];
            $sessionStorage.quesOption.sleep=newValue[29];
            $sessionStorage.quesOption.smoke=newValue[30];
            $sessionStorage.quesOption.burn=newValue[31];
            $sessionStorage.quesOption.TCT=newValue[32];
            $sessionStorage.quesOption.pregnant=newValue[33];
            $sessionStorage.quesOption.exam=newValue[34];
            $sessionStorage.iList.list2==newValue[35];
            $sessionStorage.iList.list3==newValue[36];
            $sessionStorage.iList.list4==newValue[37];
            $sessionStorage.iList.list6==newValue[38];
            $sessionStorage.iList.list12==newValue[39];
            $sessionStorage.iList.list13==newValue[40];
            $sessionStorage.iList.list15==newValue[41];
            $sessionStorage.iList.list16==newValue[42];
            $sessionStorage.iList.list17==newValue[43];
            $sessionStorage.iList.list22==newValue[44];
            $sessionStorage.iList.list23==newValue[45];
        }
    );
    $scope.goTcdz2=function () {
        if($scope.option.age=='选择年龄'){
            $scope.mPop.err('请选择年龄!');
        }else if($scope.option.height==null){
            $scope.mPop.err('请填写身高!');
        }else if($scope.option.weight==null){
            $scope.mPop.err('请填写体重!');
        }else if($scope.option.waist==null){
            $scope.mPop.err('请填写腰围!');
        }else{
            $state.go('tcdz2')
        }
    };
    $scope.goTcdz3=function () {
        if($scope.option.family_history=='选择家族史'){
            $scope.mPop.err('请选择第一题!');
        }else if($scope.option.past_history=='选择既往病史'){
            $scope.mPop.err('请选择第二题!');
        }else if($scope.option.allerg_history=='选择过敏史'){
            $scope.mPop.err('请选择第三题!');
        }else if($scope.option.sleep_quality=='选择'){
            $scope.mPop.err('请选择第六题!');
        }else if($scope.option.habit=='选择'){
            $scope.mPop.err('请选择第七题!');
        }else if($scope.option.smoke_year=='选择'){
            $scope.mPop.err('请选择第九题!');
        }else if($scope.option.passive_smoke=='选择'){
            $scope.mPop.err('请选择第十题!');
        }else if($scope.option.exercise=='选择'){
            $scope.mPop.err('请选择第十一题!');
        }else if($scope.option.diet=='选择'){
            $scope.mPop.err('请选择第十二题!');
        }else if($scope.option.drink=='选择'){
            $scope.mPop.err('请选择第十三题!');
        }else if($scope.option.anorectal=='选择'){
            $scope.mPop.err('请选择第十四题!');
        }else if($scope.option.urinary=='选择'){
            $scope.mPop.err('请选择第十五题!');
        }else if($scope.option.blue=='选择'){
            $scope.mPop.err('请选择第十六题!');
        }else if($scope.option.vertebral=='选择'){
            $scope.mPop.err('请选择第十七题!');
        }else if($scope.option.examination=='选择'){
            $scope.mPop.err('请选择第十八题!');
        }else{
            $state.go('tcdz3');
        }
    };
    $scope.goTcdz4=function (type) {
        if(type==0){
            $scope.option.breast='选择';
            $scope.option.menstruation='选择';
            $scope.option.menopause='选择';
            $scope.option.TCT='是';
            $scope.option.pregnant='是';
            $state.go('tcdz4');
        }else if(type==1){
            if($scope.option.breast=='选择'){
                $scope.mPop.err('请选择第一题!');
            }else if($scope.option.menstruation=='选择'){
                $scope.mPop.err('请选择第二题!');
            }else if($scope.option.menopause=='选择'){
                $scope.mPop.err('请选择第三题!');
            }else{
                $state.go('tcdz4');
            }
        }
    };
    $scope.goTcdz5=function (type) {
        if(type==0){
            $scope.option.physical='选择';
            $scope.option.doctor_number='选择';
            $scope.option.exam='是';
            $scope.option.symptom='选择';
            $scope.option.activity='选择';
            $scope.submit();
        }else if(type==1){
            if($scope.option.physical=='选择'){
                $scope.mPop.err('请选择第一题!');
            }else if($scope.option.doctor_number=='选择'){
                $scope.mPop.err('请选择第二题!');
            }else if($scope.option.symptom=='选择'){
                $scope.mPop.err('请选择第四题!');
            }else if($scope.option.activity=='选择'){
                $scope.mPop.err('请选择第五题!');
            }else{
                $scope.submit();
            }
        }
    };
    $scope.submit=function () {
        $http.post('/personal/health-question-api/add',$scope.option).success(function (resp) {
            console.log(resp);
            $state.go('tcdz5');
        })
    }
}]);
