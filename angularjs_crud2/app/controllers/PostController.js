var URL= 'http://localhost/php_tutorial/angularjs_crud2';
app.controller('PostController', function($scope,$http){
 
  $scope.data = [];
  $scope.add = {};

  getResultsPage();

  function getResultsPage(searchVal=false) {
    $http({
      url: URL + '/api/getData.php',
      method: 'POST',
      data:{
        searchVal: searchVal
      }
    }).then(function(res){
      $scope.data = res.data.data;
    });
  }

  // code for search action button
  $scope.searchAction = function()
  {
     var searchVal =  $scope.search;
     getResultsPage(searchVal);
     
  }

  // Code to insert data
  $scope.saveAdd = function(){
    $http({
      url: URL + '/api/add.php',
      method: 'POST',
      data: $scope.add
    }).then(function(data){
      console.log("data value", data);
      if(data.status == 200)
      {
        $scope.data.push(data.data);
      }
      $(".modal").modal("hide");
    });
  }

  // code to get data to edit
  $scope.edit = function(id){
    $http({
      url: URL + '/api/edit.php?id='+id,
      method: 'GET'
    }).then(function(data){
      $scope.form = data.data;
    });
  }

  // code to save updated data
  $scope.saveEdit = function(){
    $http({
      url: URL + '/api/update.php?id='+$scope.form.id,
      method: 'POST',
      data: $scope.form
    }).then(function(data){
      // console.log("edit get value", data);
      console.log("scope data value", $scope.data);
      $(".modal").modal("hide");
        $scope.data = apiModifyTable($scope.data,data.data.id,data.data);
    });
  }

  // code to delete data
  $scope.remove = function(post,index){
    var result = confirm("Are you sure delete this post?");
   	if (result) {
      $http({
        url: URL + '/api/delete.php?id='+post.id,
        method: 'DELETE'
      }).then(function(data){
        $scope.data.splice(index,1);
      });
    }
  }
   
});