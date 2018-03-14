var myapp=angular.module('myapp',['ui.router']);
//路由配置
myapp.config(function ($stateProvider,$urlRouterProvider) {
  $stateProvider
    .state("home",{//主页
      url:"/home",
      templateUrl:"views/home.html",
      controller:'homeCtrl'
    })
    .state("collection",{//专业人才采集
      url:"/collection",
      templateUrl:"views/collection.html"
    })
    .state("registerAudit",{//人才自主注册审核
      url:"/registerAudit",
      templateUrl:"views/registerAudit.html"
    })
    .state("addAndDelete",{//人才管理增删
      url:"/addAndDelete",
      templateUrl:"views/addAndDelete.html"
    })
    .state("permissions",{//人才管理权限
      url:"/permissions",
      templateUrl:"views/permissions.html"
    })
    .state("login",{//登陆界面
      url:"/login",
      templateUrl:"views/login.html",
      controller:'logoCtrl'
    });
  //默认进入页面
  $urlRouterProvider.otherwise("home");
});
myapp.controller('mainCtrl',function ($scope,$rootScope,$http,$state,$interval) {
  $('.my-nav li').on('click',function () {
    $(this).find('a').addClass('my-active').end().siblings().find('a').removeClass('my-active');
  })
});
myapp.controller('homeCtrl',function ($scope,$http,$state) {
  var chart1 = echarts.init(document.getElementById('chart1'));
  var option1 = {
    /*title: {
      text: '性别分布',
      left:20,
      top:'center',
      textStyle: {
        color: '#000'
      }
    },*/
    tooltip: {
      trigger: 'item',
      formatter: "{a} <br/>{b}: {c} ({d}%)"
    },
    series : [
      {
        name: '性别比例',
        type: 'pie',
        radius: '70%',
        data:[
          {value:400, name:'男性'},
          {value:335, name:'女性'}
        ],
        itemStyle: {
          normal: {
            // 阴影的大小
            shadowBlur: 200,
            // 阴影水平方向上的偏移
            shadowOffsetX: 0,
            // 阴影垂直方向上的偏移
            shadowOffsetY: 0,
            // 阴影颜色
            shadowColor: 'rgba(0, 0, 0, 0.3)'
          }
        },
        itemStyle: {
          normal: {
            label:{
              show: true,
//	                            position:'inside',
              formatter: '{b} : {c} ({d}%)'
            }
          },
          labelLine :{show:true}
        }
      }
    ]
  };
  chart1.setOption(option1);
  var chart2 = echarts.init(document.getElementById('chart2'));
  var option2 = {
    /*title: {
      text: '学历分布',
      left: 'center',
      top: 20,
      textStyle: {
        color: '#000'
      }
    },*/
    tooltip : {
      trigger: 'item',
      formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    color:['#4f81bd','#c0504d','#9bbb59','#f79646','#8064a2'],
    legend: {
      orient: 'vertical',
      x: 'right',
      y:'center',
      data: ['初中','高中','本科','硕士','博士'],
      formatter:function(name){
        var oa = option2.series[0].data;
        var num=0;
        oa.forEach(function (item) {//计算总数
          num+=item.value;
        });
        for(var i = 0; i < option2.series[0].data.length; i++){
          if(name==oa[i].name){
            return name + '     ' + oa[i].value + '     ' + (oa[i].value/num * 100).toFixed(2) + '%';
          }
        }
      }
    },
    series : [
      {
        name: '学历比例分析',
        type: 'pie',
        radius : '70%',
        center: ['40%', '50%'],
        data:[
          {value:335, name:'初中'},
          {value:310, name:'高中'},
          {value:234, name:'本科'},
          {value:135, name:'硕士'},
          {value:186, name:'博士'}
        ],
        itemStyle: {
          emphasis: {
            shadowBlur: 10,
            shadowOffsetX: 0,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        },
        itemStyle: {
          normal: {
            label:{
              show: true,
//	                            position:'inside',
              formatter: '{b} : {c} ({d}%)'
            }
          },
          labelLine :{show:true}
        }
      }
    ]
  };
  chart2.setOption(option2);
  var chart3 = echarts.init(document.getElementById('chart3'));
  var option3 = {
    /*title: {
      text: '地区分布',
      left: 'center',
      top: 20,
      textStyle: {
        color: '#000'
      }
    },*/
    tooltip : {
      trigger: 'axis',
      axisPointer : {            // 坐标轴指示器，坐标轴触发有效
        type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
      }
    },
    grid: {
      left: '3%',
      right: '4%',
      bottom: '3%',
      containLabel: true
    },
    xAxis : [
      {
        type : 'category',
        data : ['当湖街道', '钟埭街道', '曹桥街道', '乍浦镇', '新埭镇', '新仓镇', '独山港镇','广陈镇','林埭镇'],
        axisTick: {
          alignWithLabel: true
        }
      }
    ],
    yAxis : [
      {
        type : 'value'
      }
    ],
    series : [
      {
        name:'用户量',
        type:'bar',
        barWidth: '60%',
        data:[600, 652, 200, 334, 390, 330, 220,150,60],
        itemStyle: {
          normal: {
            color: function(params) {
              // build a color map as your need.
              var colorList = ['#4f81bd','#c0504d','#9bbb59','#8064a2','#4bacc6','#f79646','#2c4d75','#772c2a','#5f7530'];
              return colorList[params.dataIndex]
            },
            shadowBlur: 200,
            shadowColor: 'rgba(0, 0, 0, 0.5)'
          }
        }
      }
    ],
  };
  chart3.setOption(option3);
  chart1.on('click',function (params) {
    console.log(params.name,params.data,params.dataIndex);
  });
  chart2.on('click',function (params) {
    console.log(params.name,params.data,params.dataIndex);
  });
  chart3.on('click',function (params) {
    console.log(params.name,params.data,params.dataIndex);
  })
}).controller('logoCtrl',function ($scope,$http,$state) {

});
