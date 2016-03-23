var app = angular.module("DMA", []);

app.controller('CreatefieldController', function ($scope, $compile) {

    $scope.fields = [
        {
            field_label: 'Field 1',
            field_name: "fields[field_1][field_name]",
            review_file: "fields[field_1][review_file]",
            all_db: "fields[field_1][all_db]",
        },
    ];

    $scope.count = 1;

    $scope.addField = function () {
        var count = ++$scope.count;
        var next = {
            field_label: 'Field ' + count,
            field_name: "fields[field_" + count + "][field_name]",
            review_file: "fields[field_" + count + "][review_file]",
            all_db: "fields[field_" + count + "][all_db]",
        };
        $scope.fields.push(next);
    }
    
    $scope.clock = "2 O clock";

//    $scope.removeField = function (key) {
//        console.log(key);
//        //$scope.fields.splice(key, 1);
//    }

});

app.directive("fields", function () {
    var directive = {};
    directive.restrict = 'E';
    directive.templateUrl = "../local/app/views/category/table-fields.html"
    directive.scope = {
        item: "=name",
        hillMin: "=",
    }

    directive.link = function (scope, element, attrs) {
        scope.removeField = function (key) {
            element.html("");
        }

    }

    return directive;
});