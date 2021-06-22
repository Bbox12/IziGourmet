
        <?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        require_once __DIR__ . '/firebase1.php';
        require_once __DIR__ . '/push1.php';
 
        $firebase = new Firebase();
        $push = new Push();
 
       
     
        // notification title
        $title = isset($_POST['title']) ? $_POST['title'] : '';

         $image = isset($_POST['image']) ? $_POST['image'] : '';
         
        // notification message
        $message = isset($_POST['message']) ? $_POST['message'] : '';
         
        // push type - single user / topic
        $push_type = isset($_POST['push_type']) ? $_POST['push_type'] : '';
         
        // whether to include to image or not
        //$include_image = isset($_GET['include_image']) ? TRUE : FALSE;
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
 
        if ($push_type == 'topic') {
            $json = $push->getPush();
            $response = $firebase->sendToTopic('global', $json);
        } else if ($push_type == 'individual') {
            $json = $push->getPush();
            $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
            $response = $firebase->send($regId, $json);
            echo $response;
        }
        ?>
     