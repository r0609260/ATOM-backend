<?php 

	$dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
    $dbuser = 'inventorydb';      //mysql用户名
    $dbpass = 'inventorydb';//mysql用户名密码
    $dbname = 'inventorydb';

	$upload_path = 'uploads/';

	$server_ip = gethostbyname(gethostname());

	$upload_url = 'https://labtools.groept.be/inventory/'.$upload_path;

	$response = array(); 

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST['name']) and isset($_FILES['image']['name'])){
			$con = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die('unable to connect to database ');
			$name = $_POST['name'];

			$fileinfo = pathinfo($_FILES['image']['name']);

			$extension = $fileinfo['extension'];


			$file_url = $upload_url . getFileName() . '.'.$extension; 

			$file_path = $upload_path. getFileName(). '.'.$extension; 

			try{

				move_uploaded_file($_FILES['image']['tmp_name'], $file_path);

				$sql_duplicate = "SELECT * FROM itemPicture WHERE itemPictureClassification = '$name'";

				if($sql_duplicate1 = mysqli_query($con,$sql_duplicate)){

					$rowDuplicate=mysqli_fetch_row($sql_duplicate1);

					echo($rowDuplicate[0]);

					$sql = "INSERT INTO itemPicture (pictureUrl, itemPictureClassification) VALUES ('$file_url','$name')";
 				   
 				    $sql2 = "UPDATE  itemPicture
                        SET pictureUrl = '$file_url'
                        WHERE itemPictureClassification = '$name'";




					//OK: No duplicate pictures
                    if($rowDuplicate[0] == NULL){

						if(mysqli_query($con,$sql)){
							$response['error'] = false; 
							$response['url'] = $file_url; 
							$response['name'] = $name; 
						}

                    }
                    else{

                        if(mysqli_query($con,$sql2)){
							$response['error'] = false; 
							$response['url'] = $file_url; 
							$response['name'] = $name; 
						}

                    }

				}

			}catch(Exception $e){
				$response['error'] = false; 
				$response['message'] = $e->getMessage(); 
			}
			mysqli_close($con);

		}else{
			$response['error'] = true; 
			$response['message'] = 'please choose a file';
		}
		
		echo json_encode($response);
	}

	function getFileName(){
		$dbhost = '127.0.0.1:3306';  //mysql服务器主机地址
	    $dbuser = 'inventorydb';      //mysql用户名
	    $dbpass = 'inventorydb';//mysql用户名密码
	    $dbname = 'inventorydb';

		$con = mysqli_connect($dbhost, $dbuser, $dbpass,$dbname) or die('unable to connect to database ');

    	$sql = "SELECT max(itemPictureID) as itemPictureID FROM itemPicture";
		$result = mysqli_fetch_array(mysqli_query($con,$sql));
		mysqli_close($con);
		if($result['itemPictureID']==null){
			return 1; 
		}else{
			return ++$result['itemPictureID'];
		}
	}