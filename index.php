<?php
    header("Content-type:text/html;charset=utf-8");

    //先搞定categories数据，数组转化成字符串注入js
    $cateArr = array('礼拜一', '礼拜二', '礼拜三', '礼拜四', '礼拜五');
    $cate = '';
    foreach($cateArr as $k=>$v){
        $cate .= '\''.$v.'\',';
    }
    $cate = rtrim($cate,',');

    //再搞定series数据，数组转化为json然后注入js中
    $seriesArr = array(
        array(
            'name'=>'魏倩倩',
            'data'=>'11,22,33,44,55'
        ),
        array(
            'name'=>'王娜娜',
            'data'=>'13,25,5,28,17'
        ),
        array(
            'name'=>'王秀丽',
            'data'=>'23,11,19,18,27'
        ),
        array(
            'name'=>'桂绍彬',
            'data'=>'21,14,5,17,37'
        ),
        array(
            'name'=>'年美玲',
            'data'=>'31,35,35,29,27'
        ),
        array(
            'name'=>'杨吉凌',
            'data'=>'15,35,5,18,37'
        )
    );

    $series = json_encode($seriesArr);

?>
<!DOCTYPE html>
<html>
<head lang="zh-cn">
    <meta charset="UTF-8">
    <title>图表实例</title>
</head>
<body>
    <div id="container" style="min-width:800px;height:400px"></div>


    <script src="js/jquery-2.2.3.min.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script src="js/themes/sand-signika.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {

            var options = {
                // Highcharts 配置
                chart: {
                    renderTo: "container",                 // 注意这里一定是 ID 选择器
                    type: 'column'                         //指定图表的类型，默认是折线图（line）
                },
                title: {
                    text: 'bug发布图表'      //指定图表标题
                },
                xAxis: {
                    //categories: ['星期一', '星期二', '星期三','星期四','星期五']   //指定x轴分组
                    categories : [<?php echo $cate; ?>]
                },
                yAxis: {
                    title: {
                        text: 'bug数'                  //指定y轴的标题
                    }
                },
                series: []
            };

            //处理series的json数据
            var items = <?php echo $series; ?>;
            $.each(items,function(index,element){
                var serobj = {
                    data : []
                };

                serobj.name=element.name;

               var ds = element.data.split(',');

                $.each(ds,function(p1,p2){
                    serobj.data.push(parseInt(p2));
                });

                options.series.push(serobj);
            });


            //创建图表对象
            var charts = new Highcharts.Chart(options);


        });
    </script>
</body>
</html>