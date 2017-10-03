
		app.controller('catalogctrl', function($scope, $http) {
		    $scope.currentPage = 1;
		    $scope.numPerPage = 4;
		    $cfdata = {params:{categoryName : "<?php echo $CatName; ?>" , pageNo : 1 , orderBy : "ProductID" , NPP:$scope.numPerPage}};
		    $http.get("<?php echo base_url(); ?>catalog/getProducts" ,$cfdata)
		    .then(function(response) {
		        $scope.myCatalog = response.data;
		        console.log($scope.myCatalog);
		    });

		    $scope.myCatalogfn = function($PageNo) {
			    $cfdata = {params:{categoryName : "<?php echo $CatName; ?>" , pageNo : $scope.currentPage , orderBy :  "ProductID" , NPP : $scope.numPerPage}};
		    	 $http.get("<?php echo base_url(); ?>catalog/getProducts" ,$cfdata)
		    	    .then(function(response) {
		    	        $scope.myCatalog = response.data;
		    	        if($scope.myCatalog)
		    	        	$scope.$apply();
				       // console.log($scope.myCatalog);
		    	    });
		    };
		});