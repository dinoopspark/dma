var app = angular.module("DMA", []);

app.controller('CreatefieldController', function ($scope, fieldService) {

    $scope.fields = [];
    $scope.fields = fieldService.addField($scope.fields);

    $scope.addField = function () {
        $scope.fields = fieldService.addField($scope.fields);
    }
});

app.controller('editCategoryController', function ($scope, fieldService, $http) {

    
    
    var model_id = angular.element(document.getElementsByName('model_id')).val();
    var data = {model_id: model_id, action: 'get_field_set'};

    $http.post(dmaGlobal.ajax_url, data).then(function (response) {
        
        var json_string = response.data[0].field_set;
        $scope.fields = angular.fromJson(json_string);
        
    });

    var json_string = '[{"id":"7","category_id":"11","field_name":"gi","review_file":"1","all_db":"1"},{"id":"8","category_id":"11","field_name":"TI","review_file":"1","all_db":"0"}]';

    

    $scope.addField = function () {
        $scope.fields = fieldService.addField($scope.fields);
    }


});

app.directive("fields", function () {
    var directive = {};
    directive.restrict = 'E';
    directive.templateUrl = dmaGlobal.base_url + "/local/app/views/category/table-fields.html";
    directive.scope = {
        itemset: "=",
        item: "=",
        key: "=",
    }

    directive.link = function (scope, element, attrs) {
        scope.removeField = function (key) {
            scope.itemset.splice(key, 1);
        }
    }

    return directive;
});



app.service("fieldService", function () {
    this.addField = function (fields) {
        var next = {
            field_name: "",
            review_file: "0",
            all_db: "1",
        };

        fields.push(next);
        return fields;
    }
});