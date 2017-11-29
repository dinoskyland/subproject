<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

use Nurigo\Api\Message;
use Nurigo\Exceptions\CoolsmsException;

include_once '../clisconnect.php';
require __DIR__ . '/../../vendor/autoload.php';
// include __DIR__ . '/sms/examples/Message/send.php';

if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$phone = $_SESSION['phone']; 

$smsMessage = 'Pickup 요청당일 Status 변경 불가. CROCENT담당자에게 연락바람. 02-2088-6277';

$api_key    = 'NCS57972CD8E106E';
$api_secret = '20A4812812469C1A7B58164F48FB15D0';

try {
    // initiate rest api sdk object
    $rest = new Message($api_key, $api_secret);
    
    // 4 options(to, from, type, text) are mandatory. must be filled
    $options       = new stdClass();
    $options->to   = $phone; // 수신번호
    $options->from = '07088540484'; // 발신번호
    $options->type = 'SMS'; // 90byte, 20won
    // $options->type = 'LMS'; // 2000byte , 50won
    // $options->type = 'MMS'; // text+image
    $options->text = $smsMessage; // 문자내용
    
    //$options->mode = 'test'; // 'test' 모드. 실제로 발송되지 않으며 전송내역에 60 오류코드로 뜹니다. 차감된 캐쉬는 다음날 새벽에 충전 됩니다.
    // $options->delay = 10;                         // 0~20사이의 값으로 전송지연 시간을 줄 수 있습니다.
    // $options->force_sms = true;                   // 푸시 및 알림톡 이용시에도 강제로 SMS로 발송되도록 할 수 있습니다.
    // $options->refname = '';                       // Reference name 
    // $options->country = 'KR';                     // Korea(KR) Japan(JP) America(USA) China(CN) Default is Korea
    //$options->datetime = $datepicker;        // Format must be(YYYYMMDDHHMISS) 2014 01 06 15 30 00 (2014 Jan 06th 3pm 30 00)
    //$options->datetime = '20160725232000';        // Format must be(YYYYMMDDHHMISS) 2014 01 06 15 30 00 (2014 Jan 06th 3pm 30 00)
    // $options->mid = 'mymsgid01';                  // set message id. Server creates automatically if empty
    // $options->gid = 'mymsg_group_id01';           // set group id. Server creates automatically if empty
    // $options->subject = 'Hello World';            // set msg title for LMS and MMS
    // $options->charset = 'euckr';                  // For Korean language, set euckr or utf-8
    // $options->sender_key = '55540253a3e61072...'; // 알림톡 사용을 위해 필요합니다. 신청방법 : http://www.coolsms.co.kr/AboutAlimTalk
    // $options->template_code = 'C004';             // 알림톡 template code 입니다. 자세한 설명은 http://www.coolsms.co.kr/AboutAlimTalk을 참조해주세요.
    // $options->app_version = 'Purplebook 4.1'      // 어플리케이션 버전
    
    $result = $rest->send($options);
    print_r($result);
}
catch (CoolsmsException $e) {
    echo $e->getMessage(); // get error message
    echo $e->getCode(); // get error code
}

?>
