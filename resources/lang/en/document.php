<?php return [
    'status'    => [
        'Draft'         => 'Draft',
        'InProgress'    => 'In Progress',
        'Approved'      => 'Approved',
        'Completed'     => 'Completed',
        'Rejected'      => 'Rejected',
        'Closed'        => 'Closed',
        'Invalid'       => 'Invalid',
        'Unknown'       => 'Unknown',
    ],

    'prepareIt'     => [
        'Validate',
        '_' => 'Validate :document',
        '?' => 'You are about to validate the :document',
    ],
    'approveIt'     => [
        'Approve',
        '_' => 'Approve :document',
        '?' => 'You are about to approve the :document',
    ],
    'rejectIt'      => [
        'Reject',
        '_' => 'Reject :document',
        '?' => 'You are about to reject the :document',
    ],
    'completeIt'    => [
        'Complete',
        '_' => 'Complete :document',
        '?' => 'You are about to complete the :document',
    ],
];