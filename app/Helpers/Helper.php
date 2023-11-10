<?php 
use Aws\S3\S3Client;

function getRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function getAlphaNumKey($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $randomString;
}

function getActionName() {
    $controller = $method = '';
    if(\Route::currentRouteAction() != null) {
        $currentAction = \Route::currentRouteAction();
        list($controller, $method) = explode('@', $currentAction);
        $controller = preg_replace('/.*\\\/', '', $controller);
    }
    
    return array($controller, $method);
}

function checkAuthorization($users) {
    abort_if(!in_array(Auth::user()->user_role->role_code, $users), 401);
}

function generateFileName($fname) {
    $date = new DateTime();
    $timestamp = $date->getTimestamp();
    
    $pos = strrpos($fname, ".");
    $file_name_without_ext = substr($fname, 0, $pos);
    $file_name_without_ext = str_replace(' ', '_', $file_name_without_ext);
    $extension = substr($fname, $pos);
    $file_name = $file_name_without_ext."_".$timestamp.$extension;
    return $file_name;
}

function uploadToBucket($file, $file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    try{
        $result = $client->putObject([
            'Bucket'     => $bucket,
            'Key'        => $file_key,
            'SourceFile' => $file,
            'ACL'        => 'private',
        ]);
    } catch (S3Exception $e) {
        //echo $e->getMessage() . "\n";
    }
}

function uploadToBucketPublic($file, $file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    try{
        $result = $client->putObject([
            'Bucket'     => $bucket,
            'Key'        => $file_key,
            'SourceFile' => $file,
            'ACL'        => 'public-read-write',
        ]);
    } catch (S3Exception $e) {
        //echo $e->getMessage() . "\n";
    }
}

function downloadFromBucket($path_to_save, $file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    $client->getObject(array(
        'Bucket' => $bucket,
        'Key'    => $file_key,
        'SaveAs' => $path_to_save
    ));
    
    //return $disk->download($upload_dir.'/'.$file_name);
}

function getLinkFromBucket($file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    $cmd = $client->getCommand('GetObject', [
        'Bucket' => $bucket,
        'Key'    => $file_key
    ]);
    $signed_url = $client->createPresignedRequest($cmd, '+1 hour');
    return $signed_url->getUri();
}

function getLinkFromBucketPublic($file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    $plain_url = $client->getObjectUrl($bucket, $file_key);
    return $plain_url;
}

function deleteFromBucket($file_key) {
    $bucket = config('aws.AWS_DH_BUCKET');
    $client = initializeBucket();
    $client->deleteObject(array(
        'Bucket' => $bucket,
        'Key'    => $file_key,
    ));
}

function initializeBucket() {
    $client = new S3Client ([
        'version'     => config('aws.AWS_DH_VERSION'),
        'region'      => config('aws.AWS_DH_REGION'),
        'endpoint'    => config('aws.AWS_DH_HOST'),
        'credentials' => [
            'key'      => config('aws.AWS_DH_KEY_ID'),
            'secret'   => config('aws.AWS_DH_SECRET_KEY'),
        ]
    ]);
    return $client;
}

function get_formatted_date($lang, $date=null) {
    # $date in 'Y-m-d' format.
    $input_date = ($date) ? $date : date("Y-m-d");
    if($lang=='en') {
        $formatted_date = date('d M Y', strtotime($input_date));
    }else {
        setlocale(LC_TIME, 'NL_nl');
        setlocale(LC_ALL, 'nl_NL');
        $timestamp = strtotime($input_date);
        $formatted_date = strftime('%d %B %Y', $timestamp);
    }
    
    return $formatted_date;
}

function company_review_type($review_type_num) {
    $review_type = App\Models\ReviewType::firstWhere('number', $review_type_num);
    if (Auth::user()->company_user)
    {
        $company_id = Auth::user()->company_user->company_id;
        if ($review_type->company_review_type)
        {
            $company_review_type = $review_type->company_review_type->firstWhere([['company_id', $company_id], ['review_type_id', $review_type->id]]);
            if ( $company_review_type )
            {
                $review_type['name'] = $company_review_type->name;
            }
        }
    }
    return $review_type;
}
?>