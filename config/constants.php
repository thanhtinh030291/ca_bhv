<?php
return[
    'appName' => 'Claim Assistant',
    'appEmail' => env('MAIL_FROM_ADDRESS', 'admin@pacificcross.com.vn'),
    'company' => 'pcv',
    'appLogo'     => "/images/logo.png",
    'formClaimUpload'   => '/public/formClaim/',
    'formClaimStorage'  => '/storage/formClaim/',
    'sortedClaimUpload'   => '/public/sortedClaim/',
    'sotedClaimStorage'  => '/storage/sortedClaim/',

    'avantarUpload' => '/public/avantar/',
    'avantarStorage' => '/storage/avantar/',
    'signarureUpload' => '/public/signarure/',
    'signarureStorage' => '/storage/signarure/',
    'PUSHER_APP_KEY' => env('PUSHER_APP_KEY'),
    'PUSHER_APP_SECRET' => env('PUSHER_APP_SECRET'),
    'PUSHER_APP_ID' => env('PUSHER_APP_ID'),
    'PUSHER_APP_CLUSTER' => env('PUSHER_APP_CLUSTER'),
    'VAPID_PUBLIC_KEY' => env('VAPID_PUBLIC_KEY'),
    
    'attachUpload'   => '/public/attachEmail/',
    
    'paginator' => [
        'itemPerPage' => '10',
    ],
    'limit_list' => [
        10 => 10,
        20 => 20,
        30 => 30,
        40 => 40,
        50 => 50,
    ],
    'field_select' => [
        'content' => 'Content',
        'amount' => 'Amount',
    ],
    'percentSelect' => 70,

    'statusExport' => [
        'new' => 0,
        'edit' => 1,
        'note_save' => 2,
    ],
    'statusExportText' => [
        '0' => "New",
        '1' => 'Edit',
        '2' => 'Note Save',
    ],
    
    'content_ip' => [
        'ANES' => 'Chi phí phẫu thuật',
        'OPR' => 'Chi phí phẫu thuật',
        'SUR' => 'Chi phí phẫu thuật',

        'HSP' => 'Các chi phí nội trú khác, Điều trị trước và sau khi nằm viện, Phí khám bệnh hằng ngày của Bác sĩ/Bác sĩ chuyên khoa',
        'HVIS' => 'Các chi phí nội trú khác, Điều trị trước và sau khi nằm viện, Phí khám bệnh hằng ngày của Bác sĩ/Bác sĩ chuyên khoa',
        'IMIS' => 'Các chi phí nội trú khác',
        'PORX' => 'Điều trị sau khi nằm viện',
        'POSH' => 'Điều trị trước khi nằm viện',

        'RB' => 'Tiền phòng và ăn uống',

        'EXTB' => 'Giường cho người thân',

        'ICU' => 'Khoa chăm sóc đặc biệt',
        'CCU' => 'Khoa chăm sóc đặc biệt',

        'HNUR' => 'Điều dưỡng tại nhà',
        'PNUR' => 'Điều dưỡng tại nhà',

        'ER' => 'Điều trị tại phòng cấp cứu do tai nạn',

        'LAMB' => 'Chi phí xe cấp cứu',

        'DON' => 'Cấy ghép bộ phận',
        'REC' => 'Cấy ghép bộ phận',

        'CHEMO'  => 'Điều trị ung thư',
        'RADIA'  => 'Điều trị ung thư',

        'TDAM' => 'Điều trị tổn thương răng do tai nạn',
        
    ],
    'content_op' => [
        'OVRX' => 'Quyền lợi ngoại trú',
        'OV' => 'Quyền lợi ngoại trú',
        'RX' => 'Quyền lợi ngoại trú',
        'LAB' => 'Quyền lợi ngoại trú',
        'XRAY' => 'Quyền lợi ngoại trú',
        'PHYS' => 'Quyền lợi ngoại trú',
        'CHIR' => 'Quyền lợi ngoại trú',

        'ACUP' => 'Y hoc thay thế',
        'BSET' => 'Y hoc thay thế',
        'CGP' => 'Y hoc thay thế',
        'CMED' => 'Y hoc thay thế',
        'HERB' => 'Y hoc thay thế',
        'HLIS' => 'Y hoc thay thế',
        'HMEO' => 'Y hoc thay thế',
        'HYNO' => 'Y hoc thay thế',
        'OSTE' => 'Y hoc thay thế'
    ],
    
    'token_mantic' => env("token_mantic",""),
    'url_mantic' => env("url_mantic",""),
    'url_mantic_api' => env("url_mantic_api",""),
    'url_cps' => env("url_cps",""),
    'api_cps' => env("api_cps",""),
    'client_id' => env("client_id",""),
    'client_secret' => env("client_secret",""),
    'url_hbs' => env("url_hbs",""),
    'url_mobile_api'  => env("url_mobile_api",""),

    //sms
    // 'api_sms' => 'http://sandbox.sms.fpt.net/',
    // 'client_id_sms' => 'fA1804B43f07d997d4Ff9aB6879677f23204a397',
    // 'client_secret_sms' => '5d9024b461cc2A8ff3d81cA7F70dd1ceb284D90c254a06dd90e9ae5c189f57eadaBb6551',
    // //sms tesst
    'api_sms' => 'http://app.sms.fpt.net/',
    'client_id_sms' => '9e1fFba27Cf47ef6dF65e8ae837359f80d628268',
    'client_secret_sms' => 'c653183a7879cdf62edb8abd87d1ef7d51d628fb47b8a02d2e88cdc539a3Ca4f7244b323',

    'grant_type' => 'client_credentials',

    'url_query_online' => 'https://pcvwebservice.pacificcross.com.vn/bluecross/query_rest.php?id=',
    'mount_dlvn' => "http://192.168.0.237/vprod/",
    'claim_result' => [
        1 => 'FULLY PAID' ,
        2 => 'PARTIALLY PAID',
        3 => 'DECLINED' 
    ],
    'statusWorksheet' => [
        0 => 'Mặc Định',
        1 => 'Yêu Cầu Hỗ trợ MD',
        2 => 'Đã Giải Quyết'
    ],
    'notifiRoleMD' => 'Medical',
    'status_mantic' =>[
        '10' => 'new',
        '11' => 'accepted',
        '12' => 'partiallyaccepted',
        '13' => 'declined',
        '14' => 'pending',
        '15' => 're-open',
        '16' => 'inforequest',
        '17' => 'infosubmitted',
        '18' => 'readyforprocess',
        '19' => 'offered',
        '20' => 'feedback',
        '21' => 'paid_approved',
        '22' => 'finalized',
        '23' => 're-underwrite',
        '24' => 'withdrawn',
        '25' => 'issued_unpaid',
        '26' => 'begin_consultation',
        '27' => 're_consult',
        '28' => 'more_time_request',
        '30' => 'acknowledged',
        '40' => 'confirmed',
        '50' => 'assigned',
        '60' => 'open',
        '61' => 'renew',
        '62' => 'next_payment',
        '80' => 'resolved',
        '81' => 'terminated',
        '82' => 'finish_consultation',
        '90' => 'closed',
        '57' => 'paid',
        '70' => 'inforequest_sent',
        '59' => 'notpay',
        '31' => 'GOP Request',
        '32' => 'GOP Initial Approval',
        '33' => 'GOP Wait Docs'
    ],
    'status_mantic_value' => [
        'accepted' => 11,
        'partiallyaccepted' =>12,
        'declined' => 13,
        'closed' => 90,
        'inforequest' => 16,
    ],
    'payment_method' =>[
        'TT' => 'Chuyển khoản qua ngân hàng',
        'CA' => 'Nhận tiền mặt tại ngân hàng',
        'CQ' => 'Nhận tiền mặt tại văn phòng',
        'PP' => 'Đóng phí bảo hiểm cho hợp đồng'
    ],
    'debt_type' =>[
        1 => 'nợ được đòi lại',
        2 => 'nợ nhưng đã cấn trừ qua Claim khác',
        3 => 'nợ nhưng khách hàng đã gửi trả lại',
        4 => 'nợ không được đòi lại',
    ],
    'tranfer_status' => [
        10	=> "DELETED",
        20	=> "NEW",
        30	=> "LEADER APPROVAL",
        50	=> "LEADER REJECTED",
        60	=> "MANAGER APPROVAL",
        80	=> "MANAGER REJECTED",
        90	=> "DIRECTOR APPROVAL",
        110	=> "DIRECTOR REJECTED",
        140	=> "DLVN CANCEL",
        145	=> "DLVN PAYPREM",
        150	=> "APPROVED",
        160	=> "SHEET",
        165	=> "SHEET PAYPREM",
        170	=> "SHEET DLVN CANCEL",
        175	=> "SHEET DLVN PAYPREM",
        180	=> "TRANSFERRING",
        185	=> "TRANSFERRING PAYPREM",
        190	=> "TRANSFERRING DLVN CANCEL",
        195	=> "TRANSFERRING DLVN PAYPREM",
        200	=> "TRANSFERRED",
        205	=> "TRANSFERRED PAYPREM",
        210	=> "TRANSFERRED DLVN CANCEL",
        215	=> "TRANSFERRED DLVN PAYPREM",
        216	=> "RETURNED TO CLAIM",
        220	=> "DLVN CLOSED",
    ],
    'claim_type'=>[
        'M' => '(Member)',
        'P' => '(GOP)',
    ],
    'status_request_gop_pay' => [
        'request' => 'Đang đợi xác nhận',
        'accept'  => 'Đã được xác nhận',
        'reject'  => 'Đã bị từ chối',
    ],
    'category_bug' => [
        'Claim' => 15,
        'MCP_Claim' => 16,
        'CS_Claim' => 17
    ],
    'not_provider' => [
        '2095143'
    ],
    'gop_type' =>
    [
        0 => "Accepted: GOP acceptance letter is attached (Chấp nhận: Thư bảo lãnh viện phí được gửi đính kèm)",
        1 => "Client can Pay and Claim (Khách hàng tự thanh toán và gửi hồ sơ yêu cầu bồi thường cho công ty)",
        2 => "Treatment not Covered (Điều trị không được bảo hiểm)"
    ],

    'reason_unfreezed' => [
        'Additional Payment' => 'Thanh toán bổ sung',
        'Reduce payment'     => 'Giảm Thanh Toán',
        'Correct Info'       => 'Thay đổi thông tin',
        'Reverse due to wrong Member' => 'Reverse do sai Member',
    ],

    'invoice_type' => [
        'original_invoice' => 'Hóa đơn góc',
        'e_invoice' => 'Hóa đơn điện tử',
        'converted_invoice' => 'Hóa đơn đã chuyển đổi',
    ]
];