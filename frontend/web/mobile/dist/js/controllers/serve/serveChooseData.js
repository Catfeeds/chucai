'use strict';
app.controller('serveChooseDataCtrl', ['$scope','$rootScope','$http','$stateParams','$localStorage','$sessionStorage','$state','toaster','$timeout','$location',function($scope,$rootScope,$http,$stateParams,$localStorage,$sessionStorage,$state,toaster,$timeout,$location) {
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
    $scope.yfkId = $stateParams.yfkId;
    $scope.dateFlag = $stateParams.dateFlag;
    $scope.time={
        get:null,
        set:null
    };
    $scope.submit=function () {
        $scope.time.set=$scope.time.get;
        /*console.log('设置成功',$sessionStorage.serveDate);
         console.log($sessionStorage.serveDate)*/
        if($scope.dateFlag == 'yes'){
            $http.post('/order/order-api/update',{
                token:$sessionStorage.token,
                id:$scope.yfkId,
                exam_time:$sessionStorage.serveDate
            }).success(function (rep) {
                if(rep.errcode == 0){
                    console.log('体检时间更改成功')
                }
            });
            $state.go('layout.mobile.serve.yfk',{})
        }else{
            history.go(-1);
        }
    }
}])
;
app.directive('pieCalendar', function($sessionStorage) {
    var option = {
        restrict: 'AECM',
        scope : {
            myId : '@',        //解析普通字符串
            myData : '=',    //解析数据
            myFn : '&'        //函数
        },
        transclude : true,
        templateUrl: 'tpl/template/calendar.html',
        link:function(scope,elements,attributes){
            function MyDate(setTime){
                if(!setTime){
                    this.date=new Date();//默认时间
                }else{
                    this.date=new Date(setTime);//自定义时间
                }
                console.log('输入的时间',setTime)
            }
            //本月天数
            MyDate.prototype.getDays=function () {
                var mDate=new Date(this.date);
                mDate.setMonth(mDate.getMonth()+1);
                mDate.setDate(0);
                return mDate.getDate();
            };
            //上月天数
            MyDate.prototype.getLMDays=function () {
                var mDate=new Date(this.date);
                mDate.setDate(0);
                return mDate.getDate();
            };
            //本月一号星期几
            MyDate.prototype.getWeekDay=function () {
                var mDate=new Date(this.date);
                mDate.setDate(1);
                return mDate.getDay();
            };
            //输出显示列表
            MyDate.prototype.getList=function () {
                var mDate=new Date(this.date);
                var front=mDate.getFullYear()+'-'+(mDate.getMonth()+1)+'-';
                //设置成明天
                var toDate=new Date();
                var toDateTomorrow=toDate.getDate()+1;
                toDate.setDate(toDateTomorrow);
                var toMonth;
                if(mDate.getFullYear()==toDate.getFullYear() && mDate.getMonth()==toDate.getMonth()){
                    toMonth=true;
                }else{
                    toMonth=false;
                }
                var today=toDate.getDate();//明天
                // console.log('toMonth的值是',toMonth,'today的值是',today);
                var result=[];
                var last=this.getWeekDay()-1;
                var lastMonth=this.getLMDays();
                var thisMonth=this.getDays();
                for(var i=lastMonth-last+1;i<=lastMonth;i++){
                    result.push({number:i,ac:'not',content:front+i})
                }
                for(var i=1;i<thisMonth+1;i++){
                    if(toMonth && i<today){
                        result.push({number:i,ac:'not',content:front+i});
                    }else if(toMonth && i==today){
                        result.push({number:i,ac:'today',content:front+i});
                    }else{
                        result.push({number:i,ac:'',content:front+i});
                    }
                }
                var nextLength=43-result.length;
                for(var i=1;i<nextLength;i++){
                    result.push({number:i,ac:'not',content:front+i})
                }
                return(result)
            };
            //默认日
            MyDate.prototype.toDay=function () {
                var mDate=new Date(this.date);
               /* var setDate=mDate.getDate()+1;
                mDate.setDate(setDate);*/
                return(mDate.toLocaleDateString())
            };
            //默认月
            MyDate.prototype.toMonth=function () {
                var mDate=new Date(this.date);
                return(mDate.getMonth()+1)
            };
            //默认年
            MyDate.prototype.toYear=function () {
                var mDate=new Date(this.date);
                return(mDate.getFullYear())
            };
            var date=new Date();
            var tDate=date.getDate()+1;
            date.setDate(tDate);//明天
            var now=new MyDate(date);
            scope.showList={
                title:now.toDay(),
                month:now.toMonth(),
                year:now.toYear(),
                getDays:now.getDays(),
                lastMDays:now.getLMDays(),
                getWeekDay:now.getWeekDay(),
                list:now.getList(),
                nowMonth:now.toMonth(),
                nowYear:now.toYear(),
                showPreMonth:false,
                showNextMonth:true,
                showPreYear:false,
                showNextYear:true
            };
            scope.setDate=function(item,index) {
                if(item.ac!='not'){
                    scope.showList.title=item.content;
                    var setItem=elements.find('ul').eq(1).find('li');
                    for(var i=0;i<setItem.length;i++){
                        if(i==index){
                            setItem.eq(i).addClass('ac');
                        }else{
                            setItem.eq(i).removeClass('ac');
                        }
                    }
                    scope.myData=item.content;
                    console.log(scope.myData);
                    $sessionStorage.serveDate = scope.myData;
                }
            };
            scope.nextMonth=function () {scope.showList.month++};
            scope.preMonth=function () {scope.showList.month--};
            scope.nextYear=function () {scope.showList.year++};
            scope.preYear=function () {scope.showList.year--};
            scope.$watchGroup(['showList.month','showList.year','showList.nowMonth','showList.nowYear'],
                function (newValue) {
                    var setMonth=newValue[0];
                    var nowMonth=scope.showList.nowMonth;
                    var setYear=newValue[1];
                    var nowYear=scope.showList.nowYear;
                    if(setYear>nowYear){//明年
                        scope.showList.showNextYear=false;
                        scope.showList.showPreYear=true;
                        if(setMonth>=nowMonth){//大于本月
                            setMonth=nowMonth-1;
                        }else if(setMonth==nowMonth-1){//上个月
                            scope.showList.showNextMonth=false;
                            scope.showList.showPreMonth=true;
                        }
                        if(setMonth<1){
                            setMonth=12;
                            setYear--;
                        }
                    }else{//今年
                        scope.showList.showNextYear=true;
                        scope.showList.showPreYear=false;
                        if(setMonth<nowMonth){//小于本月
                            setMonth=nowMonth;
                        }else if(setMonth==nowMonth){//等于本月
                            scope.showList.showNextMonth=true;
                            scope.showList.showPreMonth=false;
                        }else{//大于本月
                            scope.showList.showPreMonth=true;
                        }
                        if(setMonth>12){
                            setMonth=1;
                            setYear++;
                        }
                        if(scope.showList.nowMonth==1){//本月是一月则年不动
                            scope.showList.showNextYear=false;
                            scope.showList.showPreYear=false;
                            if(scope.showList.month==12){
                                scope.showList.showNextMonth=false;
                            }
                        }
                    }
                    scope.showList.month=setMonth;
                    scope.showList.year=setYear;
                    var nowDate=setYear+'/'+setMonth+'/1';
                    var setNow=new MyDate(nowDate);
                    scope.showList.list=setNow.getList();
                    console.log(scope.showList);
                })
        }
    };
    return option;
});