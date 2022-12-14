<!DOCTYPE html> <!--no errors, navbar done-->
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT' crossorigin='anonymous'>
    <script src='http://code.jquery.com/jquery-1.11.1.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js' integrity='sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8' crossorigin='anonymous'></script>  
    <link rel ='stylesheet' href='css/viewProfiles.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'> <!--stars rating-->
    <link rel ='stylesheet' href='css/viewOffers.css'>
    <title>Jalees</title>


</head>

<body>
  <!-- expand يعني اختفاء البار متى ما صغرت الشاشه -->
  <div class='navbar navbar-expand-lg navbar-light text-light ' style='background-color: rgb(227, 217, 175);'>
    <div class='container-fluid'>
      <!-- making the brand name as a heading -->
      <a class='navbar-brand mb-0 h1' href='babysitterHome.php'><img src='css/images/logo.png' style='width: 35%;' alt='Logo'></a>
          <!--عرض زر عند تصغير الشاشه ومنها يتم عرض عناصر البار -->
          <button class='navbar-toggler' data-bs-toggle='collapse' data-bs-target='#cNav' aria-controls='cNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        

          <!-- justify-content-end to make left allignment -->
          <div class='collapse navbar-collapse' id='cNav'>
            <!-- list of itms in the navbar -->
            <ul class='navbar-nav' style='margin-left: -200px;'>
                <li class='nav-item'><a href='babysitterHome.php' class='nav-link'>Home</a></li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>My Jobs</a>
                    <ul class='dropdown-menu'>
                      <li><a class='dropdown-item' href='CurrentBabysitterJobs.php'>Current Jobs</a></li>
                      <li><a class='dropdown-item' href='PreviousBabysitterJobs.php'>Previous Jobs</a></li>
                    </ul>
                  </li> 
                  <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle active' data-bs-toggle='dropdown' href='#' role='button' aria-expanded='false'>My Profile</a>
                    <ul class='dropdown-menu'>
                      <li><a class='dropdown-item active' href='viewProfileBabysitter.php'>View Profile</a></li>
                      <li><a class='dropdown-item' href='EditBabysitterProfile.php'>Manage Profile</a></li>
                      <li><a class='dropdown-item' href='php/signout.php'>Log Out</a></li>
                    </ul>
                  </li>
                <li class='nav-item ' ><a href='mailto:Jalees@gmail.com' class='nav-link '>Ask Us</a></li>
            </ul>
        </div>
      </div>
    </div>
    <br>

    <h1 style='text-align: center;'>Your Profile</h1><br>

    <div class='container'>
        <?php
        session_start();
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        Define("host","localhost");
        Define("Username", "root");
        Define("Password", "");
        Define("db", "Jalees");
        $connection = mysqli_connect(host, Username, Password, db);
        if(!$connection)
        die();
        $query = "SELECT * FROM Babysitters WHERE ID=".$_SESSION['babysitterID'].";";
        $result = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($result)){
            echo "<div class='row profile'>
                <div class='col-md-3'>
                <div class='profile-sidebar'>
                <div class='profile-userpic'>
                <img src='".$row['photo']."' class='img-responsive' alt='Profile Picture'>
                </div>
                <div class='profile-usertitle'>
                <div class='profile-usertitle-job'>
                    <div id='babysitterTitle'>Babysitter</div>
                </div>
            </div>
            </div>
            </div>
            <div class='col-md-9'>
                <div class='profile-content'>
                    <div class='info'>

                        <p><strong>Name: </strong><br>".$row['firstName']." ".$row['lastName']."</p>
                    
                        <p><strong>Email:</strong> <br>".$row['email']."</p>

                        <p><strong>ID: </strong><br>".$row['userID']."</p>

                        <p><strong>Age: </strong><br>".$row['age']." years old</p>

                        <p><strong>Gender: </strong><br>".$row['gender']."</p>

                        <p><strong>Phone: </strong><br>".$row['phone']."</p>

                        <p><strong>City: </strong><br>".$row['city']."</p>
                    
                        <p><strong>Bio:</strong><br>".$row['bio']."</p>
        
                    
                    </div>
                    <div id='buttons'> 
                    <a class='btn btn-outline-secondary ' href='EditBabysitterProfile.php' role='button'>Edit Profile</a>"; }
                    $checkQuery = "SELECT * FROM jobRequests WHERE endDate > CAST(CURRENT_TIMESTAMP AS DATE) AND babysitterID IS NOT NULL AND babysitterID=".$_SESSION['babysitterID'].";";
                    $checkResult = mysqli_query($connection, $checkQuery);
                    $checkTime = "SELECT * FROM jobRequests WHERE endDate = CAST(CURRENT_TIMESTAMP AS DATE) AND endTime > CAST(CURRENT_TIMESTAMP AS TIME) AND babysitterID IS NOT NULL AND babysitterID=".$_SESSION['babysitterID'].";"; 
                    $timeResult = mysqli_query($connection, $checkTime);

                    if(mysqli_num_rows($checkResult)>0) //if has current jobs (end date in future)
                        echo"<button disabled title='You can't delete your account because you have current active jobs.' class='btn btn-outline-secondary' href='index.php' role='button' style='background-color: rgb(222, 219, 219);'>Delete Profile</button>";

                        else if(mysqli_num_rows($timeResult)>0) //if has current jobs (ends today but at a later hour)
                         echo"<button disabled title='You can't delete your account because you have current active jobs.' class='btn btn-outline-secondary' href='index.php' role='button' style='background-color: rgb(222, 219, 219);'>Delete Profile</button>";
                         
                         else //no current jobs
                       echo"<a class='btn btn-outline-secondary' href='index.php' role='button' style='color: red; border-color: red;'>Delete Profile</a>";   

                 echo "</div> 
                </div>
                </div>
                
            </div>
    
        </div> 
        <br> <hr> <br>
    
    
        <h3 style='text-align: center;'>My Ratings and Reviews:</h3> <br>  
        <div class='container'>
        <div class='row profile'>
            <div class='col-md-3'>
                <div class='profile-sidebar'>
                    <div class='profile-userpic'> 
                        <img src='css/images/feedback.png' class='img-responsive' alt='avatar' style='width: 350px;'>
                    </div>                       
                </div>
            </div>

            <div class='col-md-9'>
                <div class='profile-content'>
   


                    ";
        
        $queryReviews = "SELECT * FROM Reviews LEFT JOIN Parents ON parent=Parents.parentID WHERE babysitter=".$_SESSION['babysitterID'].";";
        $resultReviews = mysqli_query($connection, $queryReviews);
        if(mysqli_num_rows($resultReviews)>0){
        while($rowRev = mysqli_fetch_array($resultReviews)){
            echo "<article><img class='requestPicture' src=".$rowRev['photo']." alt='Profile Picture'>
            <div class='information'>
            <h5 class='requestName'><strong>Parent's name: </strong>".$rowRev['firstName']." ".$rowRev['lastName']."</h5>
            <div class='ratings'>";
            switch($rowRev['stars']){
                case '0':
                    echo "<i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
                    break;
                case '1':
                    echo "<i class='fa fa-star rating-color'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
                    break;
                case '2':
                    echo "<i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
                    break;
                case '3':
                    echo "<i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star'></i><i class='fa fa-star'></i>";
                    break;
                case '4':
                    echo "<i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star'></i>";
                    break;
                case '5':
                    echo "<i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i><i class='fa fa-star rating-color'></i>";
                    break;
            }
            echo "</div></div>
            <h6 class = 'title'>".$rowRev['title']."</h6>
            <p>".$rowRev['review']."</p>
    </article>";
        }
    }
    else{
        echo "<p style='color: grey; text-align: center; '>No reviews yet..</p>";
    }
    $connection -> close();
        ?>
    <br>
    
    <p class='footer' style="position: static; text-align: center; margin-left: 32%;">Jalees &copy;
        <a href='mailto:Jalees@gmail.com'>Contact Us</a>
    </p>


</body>
</html>
