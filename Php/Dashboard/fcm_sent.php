
        <?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        require_once __DIR__ . '/firebase.php';
        require_once __DIR__ . '/push.php';
 
        $firebase = new Firebase();
        $push = new Push();
         var_dump($_POST);
       
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
        $include_image = isset($_POST['include_image'])? $_POST['include_image'] : '';

        $push->setTitle($title);
        $push->setMessage($message);
        if ($include_image=='TRUE') {
            $push->setImage($image);
        } else {
            $push->setImage('');
        }
        $push->setIsBackground(FALSE);
        
        $json = '';
        $response = '';
 
       
            $json = $push->getPush();
            $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
            $response = $firebase->send($regId, $json);
            echo  $response;
        
        ?>
     