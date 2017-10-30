
					
		<!-- JQuery -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<!-- modal -->
		<script src="<?php echo base_url("assets/js/myModalLabel.js");?>"></script>
		<?php
		if (isset($this->session->userdata['logged_in'])) {
			
		$name = $this->session->userdata['logged_in'];
		echo"
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#userdata').html('".$name['username']."');			
			$('#userdata').attr('href','user_auth/logout');
    		$('#modal-btn').hide();
		});
		</script>	
		";
		}
		else{
			echo"
		<script type='text/javascript'>
		$(document).ready(function(){
			$('#userdata').hide();
		});
		</script>
		";
		}
		?>
		<script>

		var app = angular.module('myApp', []);
		app.controller('catalogctrl', function($scope, $http) {

		    $scope.count = [4,8,12,16,20];
		    $scope.SortA = {
		    	    "Price": "Price",
		    	    "DiscountPrice": "Discount-Price",
		    	    "ProductID": "By Time"
		    	};
		    $scope.OrderA = {
		    	    "asc": "Low to High",
		    	    "desc": "High to Low"
		    	};
		    $scope.currentPage = 1;
		    $scope.numPerPage = 8;
		    $scope.sortBY="DiscountPrice";
		    $scope.order="desc";
		    $cfdata = {params:{categoryName : "<?php echo $CatName; ?>" , pageNo : 1 , orderBy : "ProductID" , NPP:$scope.numPerPage , order:"desc"}};
		    $http.get("<?php echo base_url(); ?>catalog/getProducts" ,$cfdata)
		    .then(function(response) {
		        $scope.myCatalog = response.data;
		        console.log($scope.myCatalog);
		    });

		    $scope.myCatalogfn = function($PageNo) {
			    $cfdata = {params:{categoryName : "<?php echo $CatName; ?>" , pageNo : $scope.currentPage , orderBy :  $scope.sortBY , NPP : $scope.numPerPage , order: $scope.order}};
		    	 $http.get("<?php echo base_url(); ?>catalog/getProducts" ,$cfdata)
		    	    .then(function(response) {
		    	        $scope.myCatalog = response.data;
		    	        //if($scope.myCatalog)
		    	        	//$scope.$apply();
				        console.log($scope.sortBY);
		    	    });
		    };
		});
		</script>
		<!-- custom -->
		<script type="text/javascript" src="<?php echo base_url("assets/js/custom.js"); ?>"></script>
		
	</body>
</html>