var app = app || {};
var CoolingApp = angular.module("CoolingApp", []);

CoolingApp.controller("CoolingController",function($scope, $http, $interval){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
   
    $scope.uploadAndGenerate = function($elId, paramName){
        if(!confirm('Are you sure, you want to upload this file?')){
            return false;
        }
        var file_data = $('#'+$elId).prop('files')[0];
        var form_data = new FormData();
        form_data.append(paramName, file_data);
        form_data.append("action","generate");
        app.showModal();
        $.ajax({
            url: app.baseUrl + 'api/cooling.php',
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {    
                app.hideModal();
                if(data.success){
                    var $el = $('#'+$elId);
                    $el.wrap('<form>').closest('form').get(0).reset();
                    $el.unwrap();
                    
                    $scope.$apply(function() {
                        $scope.renderGraph(data);                        
                    });                    
                }
                else {
                    alert(data.msg)
                }
            },
            error : function(data){
                app.hideModal();
                console.log(data);
                alert("There was a problem, please try again later");
            }
        });
        return false
    };
    
    $scope.renderGraph = function($data){
        Highcharts.chart('chartContainer', {
            chart: {
                type: 'spline'
            },
            title: {
                text: 'Cooling Data Information Per Hour'
            },
            subtitle: {
                text: 'Green Building'
            },
            xAxis: {
                categories: $data.hours
            },
            yAxis: {
                title: {
                    text: 'Value'
                },
                labels: {
                    formatter: function () {
                        return this.value + '';
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                },
                series: {
                    connectNulls: false   
                }
            },
            series: [
                {
                    name: 'Data Point',
                    marker: {
                        symbol: 'square'
                    },
                    data: $data.data_point
                },
                {
                    name: 'Consecutive Anamoly Path',
                    marker: {
                        symbol: 'square'
                    },
                    data: $data.consecutive_anomaly
                }
            ]
        });
    };
    
    $scope.markerUrl = {
        symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)'
    };
    
    $scope.init = function(){
        console.log("init cooling controller")
    };
    
    $scope.init();
});

