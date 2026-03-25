<?php

return [
    'title' => 'My Safety Reports',
    'meta_title' => 'My Reports',
    'report_id' => 'Ticket #REP-:id',
    'reported_user' => 'Reported: :name',
    'status' => [
        'pending' => 'Pending',
        'resolved' => 'Resolved',
        'dismissed' => 'Dismissed',
    ],
    'date' => 'Date',
    'processed_at' => 'Processed on :date',
    'empty_state' => [
        'title' => 'You haven\'t sent any reports yet',
        'desc' => 'If you experience any security issues or inappropriate behavior, use the report button in the chat or profiles.',
    ],
];
